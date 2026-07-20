<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApiClient extends Model
{
    use HasUuids;

    protected $fillable = [
        'client_name', 'api_key', 'secret_hash',
        'allowed_ip_range', 'rate_limit', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rate_limit' => 'integer',
    ];

    public function webhooks()
    {
        return $this->hasMany(WebhookEndpoint::class, 'client_id');
    }
}
