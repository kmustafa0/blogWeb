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
                    <h4 class="mt-5 mb-3 fs-1 fw-light">Yorumlar</h4>
                    <div class="mb-3">
                        <input type="text" id="search" class="form-control" style="width: 300px;"
                            placeholder="Arama yapın...">

                    </div>
                    <table class="table">
                        <thead>
                            <tr class="text-center font-monospace">
                                <th>Yorum ID</th>
                                <th>Gönderen</th>
                                <th>Post</th>
                                <th>Yorum</th>
                                <th>Tarih</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM comments";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $postid = $row['post_id'];
                                        $sqlpost_title = "SELECT post_title from posts WHERE post_id = $postid";
                                        $result_post_title = $conn->query($sqlpost_title);
                                        $title = $result_post_title->fetch_assoc();
                                        echo "<tr class='text-center fw-lighter'>";
                                        echo "<td>" . $row["id"] . "</td>";
                                        echo "<td>" . $row["email"] . "</td>";
                                        echo "<td>" . substr($title["post_title"], 0, 20), "..." . "</td>";
                                        echo "<td>" . $row["comment"] . "</td>";
                                        $commentDate = date("d-m-Y H:i", strtotime($row["created_at"]));
                                        echo "<td>" . $commentDate . "</td>";
                                        echo "<td>";
                                        echo "<button type='button' class='btn btn-outline-info rounded fw-bold' data-bs-toggle='modal' data-bs-target='#deleteModal" . $row["id"] . "'>Detaylar</button>";
                                        echo "</td>";
                                        echo "</tr>";

                                        echo "<div class='modal fade' id='deleteModal" . $row["id"] . "' tabindex='-1' aria-labelledby='deleteModalLabel' aria-hidden='true'>";
                                        echo "<div class='modal-dialog'>";
                                        echo "<div class='modal-content'>";
                                        echo "<div class='modal-header'>";
                                        echo "<h5 class='fs-3 fw-light' id='deleteModalLabel'>Yorum Detayları</h5>";
                                        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                        echo "</div>";
                                        echo "<div class='modal-body'>";
                                        echo "<strong>Gönderen:</strong> " . $row["email"] . "<br>";
                                        echo "<strong>Post Başlığı:</strong> " . $title["post_title"] . "<br>";
                                        echo "<strong>Yorum:</strong> " . $row["comment"] . "<br>";
                                        echo "<strong>Yorum Tarihi:</strong> " . $commentDate;
                                        echo "</div>";
                                        echo "<div class='modal-footer'>";
                                        echo "<button type='button' class='btn btn-outline-dark rounded' data-bs-dismiss='modal'>Geri Dön</button>";
                                        echo "<a href='delete_comment.php?id=" . $row["id"] . "' class='btn btn-outline-danger rounded'>Yorumu Sil</a>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Henüz yorum bulunmamaktadır.</td></tr>";
                                }

                                $conn->close();
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
            const comment = row.cells[3].innerText.toLowerCase();

            if (email.includes(searchValue) || comment.includes(searchValue)) {
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