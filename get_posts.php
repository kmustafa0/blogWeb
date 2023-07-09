<?php
include "config.php";

$limit = $_GET['limit'];
$offset = $_GET['offset'];

$query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

$posts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $post = [
        'post_id' => $row['post_id'],
        'post_title' => $row['post_title'],
        'post_content' => $row['post_content'],
        'author' => $row['author'],
        'created_at' => date("d-m-Y", strtotime($row['created_at']))
    ];

    $posts[] = $post;
}

echo json_encode($posts);
?>