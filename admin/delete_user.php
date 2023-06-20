<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"])) {
        $userId = $_POST["id"];

        $sql = "DELETE FROM users WHERE id = $userId";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
} else {
    echo "error";
}

$conn->close();
?>