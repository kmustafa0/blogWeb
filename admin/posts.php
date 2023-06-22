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
                                                echo "giriş yapan: ", $_SESSION['user'];
                                            } else {
                                                echo "";
                                            } ?></h6>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Gönderi Paylaş</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="posts.php">Gönderiler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="comments.php">Yorumlar</a>
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
                    <?php
                                    if (isset($_GET["silid"])) {
                                        $sil = mysqli_query($conn, "DELETE FROM posts WHERE post_id = '" . $_GET["silid"] . "'");
                                        echo '<div class="alert alert-success mt-4">Başarıyla Silindi.</div>';
                                        header("Refresh: 1; url=posts.php");
                                    }
                                    ?>
                    <h4 class="mt-5">İçerikler</h4><br />
                    <table class="table">
                        <thead>
                            <tr>
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
                                                $postTitle = substr($content["post_title"], 0, 50);
                                                $postContent = substr($content["post_content"], 0, 50);
                                                $postAuthor = $content["author"];
                                                $postId = $content["post_id"];
                                            ?>
                            <tr>
                                <td><?php echo $postTitle; ?></td>
                                <td><?php echo $postContent; ?></td>
                                <td><?php echo $postAuthor; ?></td>
                                <td>
                                    <a href="?silid=<?php echo $postId; ?>">Sil</a>
                                    <a href="edit.php?duzid=<?php echo $postId; ?>">Düzenle</a>
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
</body>

</html>
<?php } ?>