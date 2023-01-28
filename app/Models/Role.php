<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
