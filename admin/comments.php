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
            <div class="col-md-2">
                <div class="sidebar">
                    <!-- Sidebar içeriği -->
                    <h1>MustafaK</h1>
                    <h6 class="text-black-50"><?php if (array_key_exists('user', $_SESSION)) {
                                                echo "giriş yapan: ",$_SESSION['user'];
                                            } else {
                                                echo "";
                                            }?></h6>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Gönderi Paylaş</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="posts.php">Gönderiler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="comments.php">Yorumlar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">Kullanıcılar</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2" style="position: fixed; bottom: 20px;">
                <a class="nav-link nav-link-quit" href="logout.php">Çıkış Yap</a>
            </div>
            <div class="col">
                <center>
                    <h4 class="mt-5 mb-3">Yorumlar</h4>
                    <div class="mb-3">
                        <input type="text" id="search" class="form-control" style="width: 300px;"
                            placeholder="Arama yapın...">

                    </div>
                    <table class="table">
                        <thead>
                            <tr>
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
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . substr($title["post_title"], 0, 20), "..." . "</td>";
                                    echo "<td>" . $row["comment"] . "</td>";
                                    $commentDate = date("d-m-Y H:i", strtotime($row["created_at"]));
                                    echo "<td>" . $commentDate . "</td>";
                                    echo "<td>";
                                    echo "<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModal" . $row["id"] . "'>Sil</button>";
                                    echo "</td>";
                                    echo "</tr>";

                                    echo "<div class='modal fade' id='deleteModal" . $row["id"] . "' tabindex='-1' aria-labelledby='deleteModalLabel' aria-hidden='true'>";
                                    echo "<div class='modal-dialog'>";
                                    echo "<div class='modal-content'>";
                                    echo "<div class='modal-header'>";
                                    echo "<h5 class='modal-title' id='deleteModalLabel'>Yorum Sil</h5>";
                                    echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                    echo "</div>";
                                    echo "<div class='modal-body'>";
                                    echo "<p>Bu yorumu silmek istediğinize emin misiniz?</p>";
                                    echo "<strong>Gönderen:</strong> " . $row["email"] . "<br>";
                                    echo "<strong>Gönderen:</strong> " . $title["post_title"] . "<br>";
                                    echo "<strong>Yorum:</strong> " . $row["comment"];
                                    echo "</div>";
                                    echo "<div class='modal-footer'>";
                                    echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Hayır</button>";
                                    echo "<a href='delete_comment.php?id=" . $row["id"] . "' class='btn btn-danger'>Evet, Sil</a>";
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