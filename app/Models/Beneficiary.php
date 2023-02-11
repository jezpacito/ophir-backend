<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'relationship',
        'birthdate',
        'user_id',
    ];

    const ALLOWED_BENEFICIARIES = 2;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function countBenefiaries($user)
    {
        $count = self::where('user_id', $user->id)->count();

        return $count >= self::ALLOWED_BENEFICIARIES;
    }
}
