<?php

include "config.php";
/* session_start() */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>MK | Blog</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800"
        rel="stylesheet" type="text/css" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Mustafa.Blog</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="index.php">ANA SAYFA</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="about.php">Hakkımda</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="contact.php">İletişim</a></li>
                    <li class="nav-item">
                        <?php
                        session_start();

                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                            echo '<a href="./loginAndReg/logout.php" class="nav-link px-lg-3 py-3 py-lg-4">Çıkış
                            yap</a>';
                        } else {
                            echo '<a class="nav-link px-lg-3 py-3 py-lg-4" href="./loginAndReg/login.php">Giriş
                            Yap</a>';
                        }
                        ?>

                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Page Header-->
    <header class="masthead" style="background-image: url('assets/img/home-bg.jpg')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        <h1>Mustafa.Blog</h1>
                        <span class="subheading">Full-Stack Developer</span>
                        <h4>Merhaba <span><?php if (array_key_exists('name', $_SESSION)) {
                                                echo ucfirst($_SESSION['name']);
                                            } else {
                                                echo "Misafir";
                                            } ?></span></h4>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <?php
                $content = mysqli_query($conn, "SELECT * FROM posts ORDER BY post_id DESC");

                while ($icerik = $content->fetch_array()) {
                    $title = $icerik["post_title"];
                    $postDate = date("d-m-Y", strtotime($icerik["created_at"]));

                    $authorQuery = mysqli_query($conn, "SELECT author FROM posts WHERE post_id = ".$icerik["post_id"]);
                    $authorResult = mysqli_fetch_assoc($authorQuery);
                    $author = $authorResult['author'];
                    ?>

                <div class="post-preview">
                    <a href="post.php?postid=<?php echo $icerik["post_id"]; ?>">
                        <h2 class="post-title"><?php echo $title; ?></h2>
                        <h3 class="post-subtitle"><?php echo substr($icerik["post_content"], 0, 155), "...";  ?></h3>
                    </a>
                    <p class="post-meta">
                        Paylaşan
                        <a href="#!">@<?php echo $author; ?></a>
                        <?php echo $postDate; ?>
                    </p>
                </div>
                <hr class="my-4" />

                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Footer-->
    <footer class="border-top">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <ul class="list-inline text-center">
                        <li class="list-inline-item">
                            <a href="https://twitter.com/mustafakole0">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://instagram.com/mmustafakole">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fa-brands fa-instagram fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://github.com/kmustafa0">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div class="small text-center text-muted fst-italic">Copyright &copy; Mustafa 2022</div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>