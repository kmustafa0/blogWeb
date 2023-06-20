<?php
require_once '../config.php';

$userID = $_POST["id"];
$name = $_POST["name"];
$lastname = $_POST["lastname"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$userType = $_POST["user_type"];
$username = $_POST["username"];
$password = $_POST["password"];

$sql = "UPDATE users SET name='$name', lastname='$lastname', phone='$phone', email='$email', user_type='$userType', username='$username', password='$password' WHERE id=$userID";
if ($conn->query($sql) === TRUE) {
    echo "Kullanıcı güncellendi.";
} else {
    echo "Kullanıcı güncellenirken hata oluştu: " . $conn->error;
}

$conn->close();
?>