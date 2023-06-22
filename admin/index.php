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
                    <h1>MK | Blog</h1>
                    <h6 class="text-black-50"><?php if (array_key_exists('user', $_SESSION)) {
                                                echo "giriş yapan: ",$_SESSION['user'];
                                            } else {
                                                echo "";
                                            }?></h6>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Gönderi Paylaş</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="posts.php">Gönderiler</a>
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
                <div class="content">
                    <div class="container px-10 px-lg-10">
                        <div class="row gx-4 gx-xl-5 justify-content-center">
                            <div class="col-md-15 col-lg-8 col-xl-7">
                                <center>
                                    <form method="POST">
                                        <h4 class="mt-5">İçerik Paylaş</h4>
                                        <br />
                                        <!-- Title input -->
                                        <div class="form-outline mb-6">
                                            <input type="text" id="form4Example1" placeholder="Başlık" value="<?php

                                                                                                                    if (isset($_POST["title"])) {
                                                                                                                        echo $_POST["title"];
                                                                                                                    }

                                                                                                                    ?>"
                                                name="title" class="form-control" />
                                        </div>
                                        <br />
                                        <!-- Content input -->
                                        <div class="form-outline mb-6">
                                            <textarea class="form-control" id="form4Example3" placeholder="İçerik"
                                                name="content"
                                                rows="10"><?php
                                                                                                                                                if (isset($_POST["content"])) {
                                                                                                                                                    echo $_POST["content"];
                                                                                                                                                }
                                                                                                                                                ?></textarea>
                                        </div>
                                        <br />
                                        <?php

                                            if (isset($_POST["sendPost"])) {
                                                $title = $_POST["title"];
                                                $content = $_POST["content"];
                                                $username = $_SESSION["user"];
                                                if ($title != "" && $content != "") {
                                                    $ekle = mysqli_query($conn, "INSERT INTO posts (author ,post_title, post_content) VALUES ('" . mysqli_real_escape_string($conn, $username) . "', '" . mysqli_real_escape_string($conn, $title) . "','" . mysqli_real_escape_string($conn, $content) . "')");

                                                    echo '<div class="alert alert-success">Başarıyla eklendi</div>';
                                                    header("Refresh: 1; url=index.php");
                                                } else {
                                                    echo '<div class="alert alert-danger">Boş alan bırakmayınız!</div>';
                                                }
                                            }

                                            ?>
                                        <!-- Submit button -->
                                        <button type="submit" name="sendPost"
                                            class="btn btn-primary btn-block mb-4">Paylaş</button>
                                    </form>
                                </center><br />


                            </div>
                        </div>
                    </div>
                </div>
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