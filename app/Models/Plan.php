<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Plan
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $price
 * @property string|null $year_period
 * @property int $is_active
 * @property int $is_transferrable
 * @property string|null $billing_method could be Monthly, Yearly, Quarterly, Semi-Annually, Annual
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
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
 * @mixin \Eloquent
 */
class Plan extends Model
{
    use HasFactory;

    const CURRENT_YEAR_PERIOD = 5;

    const ST_MERCY = 'St. Mercy';

    const ST_FERDINAND = 'St. Ferdinand';

    const ST_CLAIRE = 'St. Claire';

    /** BILLING METHODS */
    const ANNUAL = 'Annual';

    const SEMI_ANNUAL = 'Semi-Annually';

    const QUARTERLY = 'Quarterly';

    const YEARLY = 'Yearly';

    const MONTHLY = 'Monthly';

    protected $fillable = [
        'name',
        'description',
        'price',
        'year_period',
        'is_active',
        'is_transferrable',
        'billing_method',
    ];

    public static $plans = [
        self::ST_MERCY,
        self::ST_FERDINAND,
        self::ST_CLAIRE,
    ];

    public static $billingMethod = [
        self::ANNUAL,
        self::SEMI_ANNUAL,
        self::QUARTERLY,
        self::YEARLY,
        self::MONTHLY,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_plan')->withPivot('is_active','owner_id');
    }
}
