<?php
require_once "../config.php";

if (isset($_GET['id'])) {
  $commentId = $_GET['id'];

  $sql = "DELETE FROM comments WHERE id = '$commentId'";
  if ($conn->query($sql) === TRUE) {
    echo "Yorum başarıyla silindi.";
    header("Location: comments.php");
  } else {
    echo "Yorum silme başarısız: " . $conn->error;
  }

} else {
  echo "Yorum ID'si belirtilmedi.";
}
?>