<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Scope a query to only include users of a given type.
     */
    public function scopeOfReferredBy(Builder $query, string $referred_by_id): void
    {
        $query->where('referred_by_id', $referred_by_id);
    }
}
