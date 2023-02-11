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

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_plan')->withPivot('is_active');
    }
}
