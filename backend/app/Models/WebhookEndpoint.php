<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class WebhookEndpoint extends Model
{
    use HasUuids;

    protected $fillable = ['client_id', 'target_url', 'event_type', 'secret_token', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(ApiClient::class, 'client_id');
    }
}
