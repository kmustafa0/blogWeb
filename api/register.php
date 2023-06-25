<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($name) || empty($lastname) || empty($phone) || empty($email) || empty($username) || empty($password)) {
        $response = array('status' => 'error', 'message' => 'Boş alan bırakılamaz');
    } else {
        $sql = "INSERT INTO users (name, lastname, phone, email, username, password) VALUES ('$name', '$lastname', '$phone', '$email', '$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            $response = array('status' => 'success', 'message' => 'Kayıt başarılı');
        } else {
            $response = array('status' => 'error', 'message' => 'Kayıt başarısız: ' . $conn->error);
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
