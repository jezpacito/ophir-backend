<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Staff
 *
 * @property int $id
 * @property string|null $type
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff query()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'user_id'];

    const STAFF_MANAGER = 'Manager';

    const STAFF_AGENT = 'Agent';

    const STAFF_DIRECTOR = 'Director';

    const STAFF_ENCODER = 'Encoder';

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
