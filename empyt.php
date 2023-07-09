<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];
    $post_id = $_GET['postid'];
    $username = $_SESSION['username'];
    $created_at = date('d-m-y h:i:s');

    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, email, username, comment, created_at) 
        VALUES (:postid, :userid, :email, :username, :comment, NOW())");
    $stmt->bindParam(':postid', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':userid', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    if ($stmt->execute()) {
        header("Location: /blogWeb/post/" . $post_id);
        exit;
    } else {
        echo "Yorum kaydedilirken hata oluştu: " . $stmt->errorInfo()[2];
        exit;
    }
}