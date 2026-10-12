<?php

namespace Weba\ProductionPriority\Support;

/**
 * Permissions of this plugin that Shield does not generate, because they belong
 * to an action and not to a resource, page or widget. They are created by the
 * migration and handed to roles by the role seeder.
 */
final class Abilities
{
    public const APPLY_EVALUATION = 'apply_production_priority_evaluation';

    public const SET_ORDER_ATTRIBUTES = 'set_attributes_production_priority_order';

    public const EXPORT_REPORT = 'export_production_priority_report';

    /**
     * @return list<string>
     */
    public static function all(): array
    {
        return [self::APPLY_EVALUATION, self::SET_ORDER_ATTRIBUTES, self::EXPORT_REPORT];
    }

    public static function allows(string $ability): bool
    {
        return (bool) auth()->user()?->can($ability);
    }
}
