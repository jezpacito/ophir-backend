<?php

namespace App\Types;

enum PeriodType
{
    case ANNUAL;
    case SEMI_ANNUAL;
    case QUARTERLY;
    case MONTHLY;

    public const DEFAULT = self::MONTHLY;

    public const CURRENT_YEAR_PERIOD = 5;

    public function label(): string
    {
        return match ($this) {
            PeriodType::ANNUAL => 'Annual',
            PeriodType::SEMI_ANNUAL => 'Semi-Annual',
            PeriodType::QUARTERLY => 'Quarterly',
            PeriodType::MONTHLY => 'Monthly',
        };
    }

    public function termPeriod(int $termPeriod, int $pricing): int
    {
        return match ($this) {
            PeriodType::ANNUAL => self::validated($termPeriod, $pricing),
            PeriodType::SEMI_ANNUAL => self::validated($termPeriod, $pricing),
            PeriodType::QUARTERLY => self::validated($termPeriod, $pricing),
            PeriodType::MONTHLY => self::annualValidate($termPeriod, $pricing),
        };
    }

    public function validated(int $termPeriod, int $pricing): int
    {
        return match ($this) {
            PeriodType::MONTHLY => self::monthlyValidate($termPeriod, $pricing),
            PeriodType::SEMI_ANNUAL => self::quarterlyValidate($termPeriod, $pricing),
            PeriodType::QUARTERLY => self::semiAnnualValidate($termPeriod, $pricing),
            PeriodType::MONTHLY => self::annualValidate($termPeriod, $pricing),
        };
    }

    public static function monthlyValidate(int $termPeriod, int $pricing): int
    {
        return ($pricing / $termPeriod) * 12;
    }

    public static function quarterlyValidate(int $termPeriod, int $pricing): int
    {
        return ($pricing / $termPeriod) * 4;
    }

    public static function semiAnnualValidate(int $termPeriod, int $pricing): int
    {
        return ($pricing / $termPeriod) * 2;
    }

    public static function annualValidate(int $termPeriod, int $pricing): int
    {
        return $pricing / $termPeriod;
    }
}
