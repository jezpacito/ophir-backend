<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserRole
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $role_id
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Role|null $role
 * @property-read \App\Models\User|null $user
 * @method static Builder|UserRole active()
 * @method static Builder|UserRole newModelQuery()
 * @method static Builder|UserRole newQuery()
 * @method static Builder|UserRole query()
 * @method static Builder|UserRole whereCreatedAt($value)
 * @method static Builder|UserRole whereId($value)
 * @method static Builder|UserRole whereIsActive($value)
 * @method static Builder|UserRole whereRoleId($value)
 * @method static Builder|UserRole whereUpdatedAt($value)
 * @method static Builder|UserRole whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @mixin \Eloquent
 */
class UserRole extends Model
{
    use HasFactory;
    use LogsActivityTrait;

    protected $table = 'user_roles';

    protected $fillable = [
        'user_id',
        'role_id',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('user_id', auth()->user()->id)
            ->where('is_active', true);
    }
}
