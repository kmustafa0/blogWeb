<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login");
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
                    <?php
                        if (isset($_GET["silid"])) {
                            $sil = mysqli_query($conn, "DELETE FROM posts WHERE post_id = '" . $_GET["silid"] . "'");
                            echo '<div class="alert alert-success mt-4">Başarıyla Silindi.</div>';
                            header("Refresh: 1; url=posts");
                        }
                        ?>
                    <h4 class="mt-5 fs-1 fw-light">İçerikler</h4><br />
                    <div class="mb-3">
                        <input type="text" id="search" class="form-control" style="width: 300px;"
                            placeholder="Arama yapın...">
                    </div>
                    <table class="table">
                        <thead>
                            <tr class="text-center font-monospace">
                                <th scope="col">Başlık</th>
                                <th scope="col">İçerik</th>
                                <th scope="col">Yazar</th>
                                <th scope="col">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $veri = mysqli_query($conn, "SELECT * FROM posts ORDER BY post_id DESC");
                                while ($content = $veri->fetch_array()) {
                                    $postTitle = substr($content["post_title"], 0, 50) . "...";
                                    $postContent = substr($content["post_content"], 0, 50) . "...";
                                    $postAuthor = $content["author"];
                                    $postId = $content["post_id"];
                                ?>
                            <tr class='text-center fw-lighter'>
                                <td><?php echo $postTitle; ?></td>
                                <td><?php echo $postContent; ?></td>
                                <td><?php echo $postAuthor; ?></td>
                                <td>
                                    <a href="edit.php?duzid=<?php echo $postId; ?>"
                                        class="btn btn-outline-info rounded fw-bold">Düzenle</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </center>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var links = document.querySelectorAll(".sidebar ul.nav li.nav-item a.nav-link");
        links.forEach(function(link) {
            link.addEventListener("click", function(e) {
                if (!link.classList.contains("active")) {
                    link.classList.add("active");
                }
            });
        });
    });
    </script>
    <script>
    document.getElementById('search').addEventListener('keyup', function(event) {
        const searchValue = event.target.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');

        tableRows.forEach(function(row) {
            const title = row.cells[0].innerText.toLowerCase();
            const content = row.cells[1].innerText.toLowerCase();
            const author = row.cells[2].innerText.toLowerCase();

            if (title.includes(searchValue) || content.includes(searchValue) || author.includes(
                    searchValue)) {
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