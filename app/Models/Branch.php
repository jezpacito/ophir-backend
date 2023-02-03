<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Branch
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch query()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['branch_number', 'address', 'name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
