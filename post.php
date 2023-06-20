<?php

include "config.php";
session_start();
if (isset($_GET["postid"])) {

    $icerlk = mysqli_query($conn, "select * from posts where post_id = '" . $_GET["postid"] . "'");
    $icerik = mysqli_fetch_array($icerlk);

    $title = $icerik["post_title"];
    $newTitle = ucwords(strtolower($title));
    $content = $icerik["post_content"];
}
if (array_key_exists('loggedin', $_SESSION)) {
    $user_id = $_SESSION['id'];
    $sql = "SELECT name, email FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $email = $row['email'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $comment = $_POST['comment'];
    $post_id = $_GET['postid'];
    $username = $_SESSION['username'];
    $created_at = date('d-m-y h:i:s');

    $sql = "INSERT INTO comments (post_id, user_id, email, username, comment, created_at) 
          VALUES ('$post_id', '$user_id', '$email', '$username', '$comment', NOW())";
    if ($conn->query($sql) === TRUE) {
        header("Location: post.php?postid=" . $post_id);
    } else {
        echo "Yorum kaydedilirken hata oluştu: " . $conn->error;
    }
}



?>

<!DOCTYPE html>
<html lang="tr">

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
    <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Mustafa.Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                MENÜ
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="index.php">ANA SAYFA</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="about.php">Hakkımda</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="contact.php">İletişim</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4"
                            href="./loginAndReg/login.php"><?php if (array_key_exists('name', $_SESSION)) {
                                                                                                                        echo $_SESSION['name'];
                                                                                                                    } else {
                                                                                                                        echo 'Misafir';
                                                                                                                    } ?> </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="masthead" style="background-image: url('assets/img/post-bg.jpg')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="post-heading">
                        <h1><?php echo $newTitle; ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <article class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <p><?php echo $content; ?></p>
                </div>
            </div>
        </div>
    </article>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-4">Yorumlar</h2>
                <?php $post_id = $_GET['postid'];
                $sql = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h6 class="card-subtitle mb-2 text-muted">' . $row['created_at'] . '</h6>';
                    echo '<h6 class="">' . $row['username'] . '</h6>';
                    echo '<p class="card-text">' . $row['comment'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
                $conn->close();
                ?>

                <h3 class="mt-5 mb-3">Yorum Yaz</h3>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Kullanıcı adı:</label>
                        <input type="text" class="form-control" id="name" name="name" disabled value="<?php if (array_key_exists('username', $_SESSION)) {
                                                                                                            echo $_SESSION['username'];
                                                                                                        } else {
                                                                                                            echo 'Giriş yapmadan yorum yapamazsın !!';
                                                                                                        } ?>">
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Yorumunuz</label>
                        <textarea class="form-control" id="comment" name="comment" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Yorum Gönder</button>
                </form>
            </div>
        </div>
    </div>

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