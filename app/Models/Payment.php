<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $payment_uuid
 * @property int|null $user_plan_id
 * @property string $amount
 * @property int $is_confirmed_payment
 * @property string $referrence_number
 * @property string $status due date,on-time, delayed,pending
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\User|null $planholder
 * @property-read \App\Models\UserPlan|null $userPlan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereIsConfirmedPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereReferrenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserPlanId($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 *
 * @mixin \Eloquent
 */
class Payment extends Model
{
    use HasFactory;
    use LogsActivityTrait;

    protected $fillable = [
        'user_id',
        'payment_uuid',
        'user_plan_id',
        'amount',
        'referrence_number',
        'is_confirmed_payment',
        'status',
    ];

    public function userPlan()
    {
        return $this->belongsTo(UserPlan::class, 'user_plan_id', 'id');
    }

    public function planholder()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => decrypt($value),
        );
    }
}
