<?php

namespace App\Types\Payments;

enum PaymentStatus
{
    case PENDING; //This is a payment that has begun, but is not complete
    case FAILED; //This is a payment where the payment process failed, whether it be a credit card rejection or some other error
    case COMPLETE; //This is a payment that has been paid and the product delivered to the customer.
    case PREAPPROVED; //A preapproved payment is one where the customer has approved the payment, but it hasn’t been processed yet
    case REFUNDED; //This is a payment where money has been transferred back to the customer and the customer no longer has access to the product

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::FAILED => 'Failed',
            self::COMPLETE => 'Complete',
            self::PREAPPROVED => 'Preapproved',
            self::REFUNDED => 'Refunded',
        };
    }
}
