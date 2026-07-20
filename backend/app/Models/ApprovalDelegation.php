<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApprovalDelegation extends Model
{
    use HasUuids;

    protected $fillable = ['user_id', 'delegated_to_user_id', 'start_date', 'end_date', 'is_active'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function delegator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function proxy()
    {
        return $this->belongsTo(User::class, 'delegated_to_user_id');
    }
}
