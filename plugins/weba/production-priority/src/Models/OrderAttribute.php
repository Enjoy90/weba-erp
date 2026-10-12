<?php

namespace Weba\ProductionPriority\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Weba\ProductionPriority\Database\Factories\OrderAttributeFactory;
use Webkul\Manufacturing\Models\Order;
use Webkul\Sale\Models\Order as SaleOrder;
use Webkul\Security\Models\Scopes\OwnershipScope;
use Webkul\Security\Models\User;

class OrderAttribute extends Model
{
    use HasFactory;

    public const MIN_URGENCY_LEVEL = 1;

    public const MAX_URGENCY_LEVEL = 5;

    public const DEFAULT_URGENCY_LEVEL = 3;

    /**
     * The column holds 15 digits with 2 decimals.
     */
    public const MAX_ORDER_VALUE = 9_999_999_999_999;

    protected $table = 'production_priority_order_attributes';

    protected $fillable = [
        'urgency_level',
        'order_value',
        'sale_order_id',
        'notes',
        'manufacturing_order_id',
        'creator_id',
    ];

    protected $attributes = [
        'urgency_level' => self::DEFAULT_URGENCY_LEVEL,
    ];

    protected $casts = [
        'urgency_level' => 'integer',
        'order_value'   => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'manufacturing_order_id');
    }

    /**
     * Only meaningful while the sales plugin is installed. The ownership scope is
     * lifted because the priority of an order must not depend on who looks at it.
     */
    public function saleOrder(): BelongsTo
    {
        return $this->belongsTo(SaleOrder::class, 'sale_order_id')
            ->withoutGlobalScope(OwnershipScope::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): OrderAttributeFactory
    {
        return OrderAttributeFactory::new();
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (self $attribute): void {
            $level = $attribute->urgency_level;

            if ($level < self::MIN_URGENCY_LEVEL || $level > self::MAX_URGENCY_LEVEL) {
                throw new InvalidArgumentException(
                    sprintf('The urgency level must be between %d and %d.', self::MIN_URGENCY_LEVEL, self::MAX_URGENCY_LEVEL)
                );
            }

            if ($attribute->order_value !== null && (float) $attribute->order_value < 0) {
                throw new InvalidArgumentException('The order value must not be negative.');
            }

            if ($attribute->order_value !== null && (float) $attribute->order_value > self::MAX_ORDER_VALUE) {
                throw new InvalidArgumentException('The order value is too large.');
            }
        });

        static::creating(function (self $attribute): void {
            $attribute->creator_id ??= Auth::id();
        });
    }
}
