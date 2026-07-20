<?php

namespace App\Services;

use App\Models\ApiClient;
use App\Models\WebhookEndpoint;
use App\Models\WebhookLog;
use Illuminate\Support\Str;

class SystemIntegrationService
{
    public function registerClient(array $data): array
    {
        $apiKey = 'SAPZ-KEY-' . strtoupper(Str::random(16));
        $secret = Str::random(32);

        $client = ApiClient::create([
            'client_name' => $data['client_name'],
            'api_key' => $apiKey,
            'secret_hash' => hash('sha256', $secret),
            'allowed_ip_range' => $data['allowed_ip_range'] ?? null,
            'rate_limit' => $data['rate_limit'] ?? 1000,
            'is_active' => true,
        ]);

        return [
            'client' => $client,
            'api_key' => $apiKey,
            'secret' => $secret, // Displayed once on registration
        ];
    }

    public function registerWebhook(array $data, ?string $clientId = null): WebhookEndpoint
    {
        return WebhookEndpoint::create([
            'client_id' => $clientId,
            'target_url' => $data['target_url'],
            'event_type' => $data['event_type'],
            'secret_token' => Str::random(24),
            'is_active' => true,
        ]);
    }

    public function dispatchWebhook(string $eventType, array $payload): void
    {
        $endpoints = WebhookEndpoint::where('event_type', $eventType)->where('is_active', true)->get();

        foreach ($endpoints as $ep) {
            WebhookLog::create([
                'webhook_id' => $ep->id,
                'event_type' => $eventType,
                'payload_json' => $payload,
                'response_status' => 200, // Simulated successful payload delivery
                'attempts' => 1,
            ]);
        }
    }
}
