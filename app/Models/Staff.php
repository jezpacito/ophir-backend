<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
