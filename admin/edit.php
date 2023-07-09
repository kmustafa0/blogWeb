<?php
session_start();
ob_start();
if (!isset($_SESSION["user"])) {
    header("Location: login");
    exit();
} else {
    include "../config.php";
    $id = $_GET["duzid"];
    $veri = mysqli_query($conn, "select * from posts where post_id = '$id'");
    $veri = mysqli_fetch_array($veri);
?>
<?php
    if (isset($_POST["sendPost"])) {
        $title = $_POST["title"];
        $content = $_POST["content"];
        if ($title != "" && $content != "") {
            $ekle = mysqli_query($conn, "UPDATE `posts` SET `post_title`='" . mysqli_real_escape_string($conn, $title) . "',`post_content`='" . mysqli_real_escape_string($conn, $content) . "',`created_at`=NOW() WHERE post_id='$id'");
            echo '<div class="alert alert-success">Başarıyla Güncellendi.</div>';
            ob_end_flush();
            header("Refresh:0.3; url=edit.php?duzid=$id");
            exit();
        } else {
            echo '<div class="alert alert-danger">Boş alan bırakmayınız!</div>';
        }
    }

    if (isset($_POST["goPosts"])) {
        header("Location: posts");
        exit();
    }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MK | Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/sidebar.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "sidebar.php"; ?>
            <div class="col">
                <div class="content">
                    <div class="container px-10 px-lg-10">
                        <div class="row gx-4 gx-xl-5 justify-content-center">
                            <div class="col-md-15 col-lg-8 col-xl-7">
                                <center>
                                    <form method="POST">
                                        <h4 class="mt-5 fs-1 fw-light">İçerik Düzenle</h4>
                                        <?php
                                            if (isset($_GET["silid"])) {
                                                $sil = mysqli_query($conn, "DELETE FROM posts WHERE post_id = '" . $id . "'");
                                                echo '<div class="alert alert-success mt-4">Başarıyla Silindi.</div>';
                                                header("Refresh: 0.5; url=posts");
                                            }
                                            ?>
                                        <br />
                                        <!-- Title input -->
                                        <div class="form-outline mb-6">
                                            <input type="text" id="form4Example1" placeholder="Başlık"
                                                value="<?php echo $veri["post_title"]; ?>" name="title"
                                                class="form-control" />
                                        </div>
                                        <br />
                                        <!-- Content input -->
                                        <div class="form-outline mb-6">
                                            <textarea class="form-control" id="form4Example3" placeholder="İçerik"
                                                name="content" rows="10"><?php echo $veri["post_content"]; ?></textarea>
                                        </div>
                                        <br />
                                        <!-- Submit button -->
                                        <button type="submit" name="sendPost"
                                            class="btn btn-outline-primary rounded mb-4">Düzenle</button>
                                        <button type="submit" name="goPosts"
                                            class="btn btn-outline-dark rounded mb-4">Geri
                                            Dön</button>
                                        <a type="submit" name="goPosts" href="posts?silid=<?php echo $id; ?>"
                                            class="btn btn-outline-danger rounded mb-4">Gönderiyi Sil</a>
                                    </form>
                                </center><br />
                            </div>
                        </div>
                    </div><br />
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
<!-- İleri kısımlar için aynı kodlar devam ediyor... -->

<?php } ?>