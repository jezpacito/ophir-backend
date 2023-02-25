<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function userPlans()
    {
        return $this->belongsToMany(User::class, 'user_plan')
        ->withPivot('is_active', 'referred_by_id', 'is_transferrable', 'billing_method');
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
