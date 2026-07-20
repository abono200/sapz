<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class WebhookLog extends Model
{
    use HasUuids;

    protected $fillable = ['webhook_id', 'event_type', 'payload_json', 'response_status', 'attempts'];

    protected $casts = [
        'payload_json' => 'array',
    ];
}
