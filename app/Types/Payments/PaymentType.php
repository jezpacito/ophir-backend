<?php

namespace App\Types\Payments;

enum PaymentType
{
    case MANUAL;
    case ONLINE;
    case MANUAL_CODE;
    case ONLINE_CODE;

    public function label(): string
    {
        return match ($this) {
            PaymentType::MANUAL => 'Manual',
            PaymentType::ONLINE => 'Online',
            PaymentType::MANUAL_CODE => 'MNL',
            PaymentType::ONLINE_CODE => 'OLN',
        };
    }
}
