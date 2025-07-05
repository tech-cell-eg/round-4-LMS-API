<?php

namespace App\Enums;

enum LevelEnum : int
{
    case All = 0;
    case Beginner = 1;
    case Intermediate = 2;
    case Advanced = 3;

    public function label(): string
    {
        return match ($this) {
            self::All => 'All Levels',
            self::Beginner => 'Beginner',
            self::Intermediate => 'Intermediate',
            self::Advanced => 'Advanced',
        };
    }
}
{

}
