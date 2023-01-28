<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'guard_name'];

    const ROLE_ADMIN = 'Admin';

    const ROLE_BRANCH = 'Branch';

    const ROLE_DIRECTOR = 'Director';

    const ROLE_MANAGER = 'Manager';

    const ROLE_ENCODER = 'Encoder';

    const ROLE_AGENT = 'Agent';

    const ROLE_PLANHOLDER = 'Planholder';

    public static $roles = [
        self::ROLE_ADMIN,
        self::ROLE_DIRECTOR,
        self::ROLE_MANAGER,
        self::ROLE_ENCODER,
        self::ROLE_AGENT,
        self::ROLE_PLANHOLDER,
        self::ROLE_BRANCH,
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
