<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MobileSyncSession extends Model
{
    use HasUuids;

    protected $fillable = ['user_id', 'device_id', 'items_synced', 'status', 'error_log'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
