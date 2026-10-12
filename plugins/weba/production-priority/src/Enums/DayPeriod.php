<?php

namespace Weba\ProductionPriority\Enums;

enum DayPeriod: string
{
    case Morning = 'morning';
    case Afternoon = 'afternoon';
    case Evening = 'evening';
    case Night = 'night';

    public static function fromHour(int $hour): self
    {
        return match (true) {
            $hour >= 4 && $hour < 11  => self::Morning,
            $hour >= 11 && $hour < 15 => self::Afternoon,
            $hour >= 15 && $hour < 18 => self::Evening,
            default                   => self::Night,
        };
    }

    public function greeting(string $name): string
    {
        return __('production-priority::filament/work-panel.greeting.'.$this->value, ['name' => $name]);
    }
}
