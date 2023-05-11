<?php

namespace App\Types\Plans;

enum Types
{
    case PLANS;
    case ST_MERCY;
    case ST_FERDINAND;

    public function label(): string
    {
        return match ($this) {
            self::PLANS => 'Plans',
            self::ST_MERCY => 'St. Mercy',
            self::ST_FERDINAND => 'St. Ferdinand',
        };
    }

    public function displayOptions(): array
    {
        switch ($this) {
            case self::PLANS:
                return [
                    self::ST_MERCY->label() => self::ST_MERCY->label(),
                    self::ST_FERDINAND->label() => self::ST_FERDINAND->label(),
                ];
            default:
                return [];
        }
    }

    public static function planOptions(): array
    {
        return self::PLANS->displayOptions();
    }
}
