<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;
use CodeIgniter\HTTP\ResponseInterface;

class Notifications extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Get notifications for the current user (AJAX endpoint)
     */
    public function get()
    {
        if (!$this->isLoggedIn()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        $userId = $this->userData['id'];

        // Get unread count
        $unreadCount = $this->notificationModel->getUnreadCount($userId);

        // Get latest notifications (limit 5)
        $notifications = $this->notificationModel->getNotificationsForUser($userId, 5);

        return $this->response->setJSON([
            'success' => true,
            'unread_count' => $unreadCount,
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark a notification as read (AJAX endpoint)
     */
    public function mark_as_read($id = null)
    {
        if (!$this->isLoggedIn()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Notification ID is required'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $userId = $this->userData['id'];

        // Check if notification belongs to the user
        $notification = $this->notificationModel->where('id', $id)
                                               ->where('user_id', $userId)
                                               ->first();

        if (!$notification) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Notification not found'
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        // Mark as read
        $result = $this->notificationModel->markAsRead($id);

        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Notification marked as read'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to mark notification as read'
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
