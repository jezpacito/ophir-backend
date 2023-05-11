<?php

namespace App\Types\Payments;

enum PeriodType
{
    case ANNUAL;
    case SEMI_ANNUAL;
    case QUARTERLY;
    case MONTHLY;
    case BILLING_METHODS;

    public const DEFAULT = self::MONTHLY;

    public const CURRENT_YEAR_PERIOD = 5;

    public function label(): string
    {
        return match ($this) {
            self::BILLING_METHODS,
            self::ANNUAL => 'Annual',
            self::SEMI_ANNUAL => 'Semi-Annual',
            self::QUARTERLY => 'Quarterly',
            self::MONTHLY => 'Monthly',
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

    public function displayOptions(): array
    {
        switch ($this) {
            case self::BILLING_METHODS:
                return [
                    self::ANNUAL->label() => self::ANNUAL->label(),
                    self::SEMI_ANNUAL->label() => self::SEMI_ANNUAL->label(),
                    self::QUARTERLY->label() => self::QUARTERLY->label(),
                    self::MONTHLY->label() => self::MONTHLY->label(),
                ];
            default:
                return [];
        }
    }

    public static function billingMethods()
    {
        return self::BILLING_METHODS->displayOptions();
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
