<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateNotificationPreferencesRequest;
use App\Models\UserNotificationPreference;
use App\Services\NotificationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ApiResponse;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $unreadOnly = $request->boolean('unread_only', false);
        $notifications = $this->notificationService->getUserNotifications(
            Auth::id(),
            $unreadOnly,
            $request->input('per_page', 15)
        );

        return $this->paginatedResponse($notifications, 'User notifications retrieved.');
    }

    public function markRead(string $id)
    {
        $updated = $this->notificationService->markAsRead($id, Auth::id());
        if (!$updated) {
            return $this->errorResponse('Notification not found.', 404);
        }
        return $this->successResponse(null, 'Notification marked as read.');
    }

    public function markAllRead()
    {
        $count = $this->notificationService->markAllAsRead(Auth::id());
        return $this->successResponse(['count' => $count], "{$count} notifications marked as read.");
    }

    public function getPreferences()
    {
        $prefs = UserNotificationPreference::firstOrCreate(
            ['user_id' => Auth::id()],
            ['email_enabled' => true, 'sms_enabled' => false, 'in_app_enabled' => true]
        );

        return $this->successResponse($prefs, 'Notification preferences retrieved.');
    }

    public function updatePreferences(UpdateNotificationPreferencesRequest $request)
    {
        $prefs = UserNotificationPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->validated()
        );

        return $this->successResponse($prefs, 'Notification preferences updated.');
    }
}
