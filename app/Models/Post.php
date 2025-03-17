<?php
namespace App\Models;

use PDO;
use App\Core\Database;

class Post {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAllPosts() {
        $stmt = $this->db->prepare("
            SELECT 
                posts.id, 
                posts.user_id, 
                posts.title, 
                posts.content, 
                posts.created_at, 
                users.username 
            FROM 
                posts 
            LEFT JOIN 
                users 
            ON 
                posts.user_id = users.id 
            ORDER BY 
                posts.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createPost($user_id, $title, $content) {
        $stmt = $this->db->prepare("INSERT INTO posts (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$user_id, $title, $content]);
    }

    public function getPostById($postId) {
        $stmt = $this->db->prepare("
            SELECT 
                posts.id, 
                posts.user_id, 
                posts.title, 
                posts.content, 
                posts.created_at, 
                users.username 
            FROM 
                posts 
            LEFT JOIN 
                users 
            ON 
                posts.user_id = users.id 
            WHERE 
                posts.id = ?
        ");
        $stmt->execute([$postId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchPosts($searchTerm) {
        $searchTerm = trim($searchTerm);

        if (empty($searchTerm)) {
            $sql = "
                SELECT 
                    posts.id, 
                    posts.user_id, 
                    posts.title, 
                    posts.content, 
                    posts.created_at, 
                    users.username 
                FROM 
                    posts 
                LEFT JOIN 
                    users 
                ON 
                    posts.user_id = users.id 
                ORDER BY 
                    posts.created_at DESC
            ";
        } else {
            $sql = "
                SELECT 
                    posts.id, 
                    posts.user_id, 
                    posts.title, 
                    posts.content, 
                    posts.created_at, 
                    users.username 
                FROM 
                    posts 
                LEFT JOIN 
                    users 
                ON 
                    posts.user_id = users.id 
                WHERE 
                    posts.title LIKE :search_term 
                    OR posts.content LIKE :search_content
                ORDER BY 
                    posts.created_at DESC
            ";
        }

        $stmt = $this->db->prepare($sql);

        if (!empty($searchTerm)) {
            $searchParam = '%' . $searchTerm . '%';
            $stmt->execute([
                ':search_term' => $searchParam,
                ':search_content' => $searchParam
            ]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePost($postId, $title, $content) {
        $stmt = $this->db->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        return $stmt->execute([$title, $content, $postId]);
    }

    public function deletePost($postId) {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$postId]);
    }
}