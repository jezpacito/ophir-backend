<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentAccountRegistration
 *
 * @property int $id
 * @property int $user_id
 * @property string $payment_type
 * @property string|null $description
 * @property string $status
 * @property int $registration_fee
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccountRegistration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccountRegistration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccountRegistration query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccountRegistration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccountRegistration whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccountRegistration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccountRegistration wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccountRegistration whereRegistrationFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccountRegistration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccountRegistration whereUserId($value)
 *
 * @mixin \Eloquent
 */
class PaymentAccountRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_type',
        'description',
        'registration_fee',
        'status',
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
