<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Plan
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $price
 * @property string|null $term_period
 * @property int $is_active
 * @property int $is_transferrable
 * @property string|null $billing_occurrence could be Monthly, Yearly, Quarterly, Semi-Annually, Annual
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 *
 * @method static \Database\Factories\PlanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereBillingMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereIsTransferrable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereYearPeriod($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property int $contract_price
 * @property mixed|null $pricing billingOccurence and plan amount
 * @property mixed|null $commission position and commission amount
 * @property int $contestability_period
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $userPlans
 * @property-read int|null $user_plans_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Plan ofName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereContestabilityPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereContractPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan wherePricing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereTermPeriod($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $userPlans
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $userPlans
 *
 * @mixin \Eloquent
 */
class Plan extends Model
{
    use HasFactory;
    use LogsActivityTrait;

    protected $fillable = [
        'name',
        'description',
        'commission',
        'is_active',
        'term_period',
        'contestability_period',
        'is_transferrable',
        'pricing',
        'contract_price',
    ];

    public function userPlans()
    {
        return $this->belongsToMany(User::class, 'user_plan')
            ->withPivot('id', 'user_plan_uuid', 'is_active', 'referred_by_id', 'billing_occurrence');
    }

    /**
     * Scope a query to
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfName($query, $name)
    {
        return $query->where('name', $name)->first();
    }
}
