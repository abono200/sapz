<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotificationPreference;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function getUserNotifications(string $userId, bool $unreadOnly = false, int $perPage = 15)
    {
        $query = Notification::where('user_id', $userId);

        if ($unreadOnly) {
            $query->whereNull('read_at');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function sendNotification(User $user, string $type, string $title, string $message, ?array $data = null): Notification
    {
        $prefs = UserNotificationPreference::firstOrCreate(
            ['user_id' => $user->id],
            ['email_enabled' => true, 'sms_enabled' => false, 'in_app_enabled' => true]
        );

        $notification = Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data_json' => $data,
        ]);

        // Simulated Multi-Channel Dispatch (Email / SMS)
        if ($prefs->email_enabled) {
            // Trigger Mail Queue dispatch
        }

        if ($prefs->sms_enabled) {
            // Trigger SMS Gateway dispatch
        }

        return $notification;
    }

    public function markAsRead(string $notificationId, string $userId): bool
    {
        $notification = Notification::where('id', $notificationId)->where('user_id', $userId)->first();
        if ($notification) {
            return $notification->update(['read_at' => now()]);
        }
        return false;
    }

    public function markAllAsRead(string $userId): int
    {
        return Notification::where('user_id', $userId)->whereNull('read_at')->update(['read_at' => now()]);
    }
}
