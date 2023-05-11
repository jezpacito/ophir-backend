<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Beneficiary
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $lastname
 * @property string|null $relationship
 * @property string|null $birthdate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\BeneficiaryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary query()
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @mixin \Eloquent
 */
class Beneficiary extends Model
{
    use HasFactory;
    use LogsActivityTrait;

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'relationship',
        'birthdate',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function countBenefiaries($user)
    {
        $count = self::where('user_id', $user->id)->count();

        return $count >= Beneficiary::ALLOWED_BENEFICIARIES;
    }
}
