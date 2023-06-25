<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $response = array('status' => 'success', 'message' => 'Giriş başarılı');
    } else {
        $response = array('status' => 'error', 'message' => 'Giriş başarısız');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
