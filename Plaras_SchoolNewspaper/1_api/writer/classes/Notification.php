<?php

require_once 'Database.php';

class Notification extends Database {

    public function createNotification($user_id, $type, $message, $related_article_id = null) {
        $sql = "INSERT INTO notifications (user_id, type, message, related_article_id) VALUES (?, ?, ?, ?)";
        return $this->executeNonQuery($sql, [$user_id, $type, $message, $related_article_id]);
    }

    public function getNotifications($user_id, $is_read = null) {
        $sql = "SELECT n.*, a.title AS article_title FROM notifications n LEFT JOIN articles a ON n.related_article_id = a.article_id WHERE n.user_id = ?";
        $params = [$user_id];
        if ($is_read !== null) {
            $sql .= " AND n.is_read = ?";
            $params[] = $is_read;
        }
        $sql .= " ORDER BY n.created_at DESC";
        return $this->executeQuery($sql, $params);
    }

    public function markAsRead($notification_id) {
        $sql = "UPDATE notifications SET is_read = 1 WHERE notification_id = ?";
        return $this->executeNonQuery($sql, [$notification_id]);
    }

    public function deleteNotification($notification_id) {
        $sql = "DELETE FROM notifications WHERE notification_id = ?";
        return $this->executeNonQuery($sql, [$notification_id]);
    }
}

?>