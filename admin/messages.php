<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
} else {

    include "../config.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MK | Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="./css/sidebar.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "sidebar.php"; ?>
            <div class="col">
                <center>
                    <h4 class="mt-5 mb-3">Mesajlar</h4>
                    <div class="mb-3">
                        <input type="text" id="search" class="form-control" style="width: 300px;"
                            placeholder="Arama yapın...">
                    </div>
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th>id</th>
                                <th>E-Mail</th>
                                <th>Mesaj Başlığı</th>
                                <th>Mesaj</th>
                                <th>Gönderim Tarihi</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $sql = "SELECT * FROM messages";
                                $result = $conn->query($sql);

                                if($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row['id'];
                                        $email = $row['email'];
                                        $subject = $row['subject'];
                                        $message = $row['message'];


                                        echo "<tr>";
                                        echo "<td>" . $id . "</td>";
                                        echo "<td>" . $email . "</td>";
                                        echo "<td>" . $subject  . "</td>";
                                        echo "<td>" . substr($message, 0, 20) . "..." . "</td>";
                                        $commentDate = date("d-m-Y H:i", strtotime($row["created_at"]));
                                        echo "<td>" . $commentDate . "</td>";
                                        echo "<td>";
                                        echo "<button type='button' class='btn btn-outline-danger me-2' data-bs-toggle='modal' data-bs-target='#deleteModal" . $row["id"] . "'>Sil</button>";
                                        echo "<button type='button' class='btn btn-outline-primary' data-bs-toggle='modal' data-bs-target='#detailsModal" . $row["id"] . "'>Düzenle</button>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                }
                            
                            ?>
                        </tbody>
                    </table>

                </center>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('search').addEventListener('keyup', function(event) {
        const searchValue = event.target.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');

        tableRows.forEach(function(row) {
            const email = row.cells[1].innerText.toLowerCase();
            const subject = row.cells[2].innerText.toLowerCase();
            const message = row.cells[3].innerText.toLowerCase();
            const created_at = row.cells[4].innerText.toLowerCase();

            if (email.includes(searchValue) || subject.includes(searchValue) || message.includes(
                    searchValue) || created_at.includes(searchValue)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });
    </script>
</body>

</html>
<?php } ?>