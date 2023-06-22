<?php

require_once '../config.php';

$userID = $_POST["id"];

$sql = "SELECT * FROM users WHERE id = $userID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user = [
        "id" => $row["id"],
        "name" => $row["name"],
        "lastname" => $row["lastname"],
        "phone" => $row["phone"],
        "email" => $row["email"],
        "user_type" => $row["user_type"],
        "username" => $row["username"],
        "password" => $row["password"]
    ];
    echo json_encode($user);
} else {
    echo "Kullanıcı bulunamadı.";
}

$conn->close();
?>