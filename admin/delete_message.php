<?php
require_once "../config.php";

if (isset($_GET['id'])) {
    $messageId = $_GET['id'];

    $sql = "DELETE FROM messages WHERE id = '$messageId'";
    if ($conn->query($sql) === TRUE) {
        echo "Mesaj başarıyla silindi.";
        header("Location: messages");
    } else {
        echo "Mesaj silme başarısız: " . $conn->error;
    }
} else {
    echo "Mesaj ID'si belirtilmedi.";
}
?>