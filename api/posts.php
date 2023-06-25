<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['postId'])) {
        $postId = $_GET['postId'];
        $sql = "SELECT * FROM posts WHERE post_id = $postId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $post = array(
                'post_id' => $row['post_id'],
                'post_title' => $row['post_title'],
                'post_content' => $row['post_content'],
                'created_at' => $row['created_at']
            );

            $response = array('status' => 'success', 'message' => 'Yazı başarıyla alındı', 'data' => $post);
        } else {
            $response = array('status' => 'error', 'message' => 'Yazı bulunamadı');
        }
    } else {
        $sql = "SELECT * FROM posts ORDER BY post_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $posts = array();

            while ($row = $result->fetch_assoc()) {
                $post = array(
                    'post_id' => $row['post_id'],
                    'post_title' => $row['post_title'],
                    'post_content' => $row['post_content'],
                    'created_at' => $row['created_at']
                );
                $posts[] = $post;
            }

            $response = array('status' => 'success', 'message' => 'Yazılar başarıyla alındı ve sıralandı', 'data' => $posts);
        } else {
            $response = array('status' => 'error', 'message' => 'Yazı bulunamadı');
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
