<?php

namespace App\Enums;

use App\Traits\BaseEnum;

enum ServiceVariantEnum: string
{
    use BaseEnum;
    
    case coach = 'coach';
    case fitness = 'fitness';
    case recovery = 'recovery';
    case therapy = 'therapy';
    case health = 'health';
    case nutrition = 'nutrition';

    public function label(): string
    {
        return match ($this) {
            self::coach => 'Coach',
            self::fitness => 'Fitness',
            self::recovery => 'Recovery',
            self::therapy => 'Therapy',
            self::health => 'Health',
            self::nutrition => 'Nutrition',
        };
    }
}
