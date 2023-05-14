<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserPlan
 *
 * @property int $id
 * @property string|null $user_plan_uuid
 * @property int|null $user_id
 * @property int|null $plan_id
 * @property int|null $referred_by_id
 * @property int $is_active
 * @property string|null $billing_occurrence Monthly, Yearly, Quarterly, Semi-Annually, Annual
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Plan|null $plan
 * @property-read \App\Models\User|null $referred_by
 * @property-read \App\Models\User|null $user
 *
 * @method static Builder|UserPlan newModelQuery()
 * @method static Builder|UserPlan newQuery()
 * @method static Builder|UserPlan ofReferredBy(string $referred_by_id)
 * @method static Builder|UserPlan query()
 * @method static Builder|UserPlan whereBillingOccurrence($value)
 * @method static Builder|UserPlan whereCreatedAt($value)
 * @method static Builder|UserPlan whereId($value)
 * @method static Builder|UserPlan whereIsActive($value)
 * @method static Builder|UserPlan wherePlanId($value)
 * @method static Builder|UserPlan whereReferredById($value)
 * @method static Builder|UserPlan whereUpdatedAt($value)
 * @method static Builder|UserPlan whereUserId($value)
 * @method static Builder|UserPlan whereUserPlanUuid($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 *
 * @mixin \Eloquent
 */
class UserPlan extends Model
{
    use HasFactory;
    use LogsActivityTrait;

    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'user_plan';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function referred_by()
    {
        return $this->belongsTo(User::class, 'referred_by_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scope a query to only include users of a given type.
     */
    public function scopeOfReferredBy(Builder $query, string $referred_by_id): void
    {
        $query->where('referred_by_id', $referred_by_id);
    }
}
