<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccountRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_type',
        'description',
        'registration_fee',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function amountPaid(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => decrypt($value),
            set: fn (string $value) => encrypt($value),
        );
    }
}
