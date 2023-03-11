<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    use LogsActivityTrait;

    protected $fillable = [
        'user_id',
        'payment_uuid',
        'user_plan_id',
        'amount',
        'referrence_number',
        'isPaid',
    ];

    const MANUAL_PAYMENT = 'MNL';

    const ONLINE_PAYMENT = 'OLN';

    public function userPlan()
    {
        return $this->belongsTo(UserPlan::class, 'user_plan_id', 'id');
    }

    public function planholder()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => decrypt($value),
        );
    }
}
