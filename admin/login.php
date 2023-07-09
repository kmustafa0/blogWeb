<?php

session_start();

include "../config.php";

if (isset($_POST["loginPost"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['user_type'] == 'admin') {
        echo "<div class='alert alert-success'>Başarılı giriş, yönlendiriliyorsunuz...</div>";
        $_SESSION['id'] = $user['id'];
        $_SESSION['usertype'] = $user['user_type'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['user'] = $username;
        $_SESSION['loggedin'] = true;
        header("Refresh: 1.5; url=index");
        exit();
    } else {
        header("Location: login");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Giriş Ekranı</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../loginAndReg/css/style.css">

</head>

<body>

    <div class="form-container">
        <form action="" method="post">
            <h3>Admin Girişi Yap</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                };
            };
            ?>
            <input type="text" name="username" required placeholder="kullanici adin" value="<?php
                                                                                                if (isset($_POST["username"])) {
                                                                                                    echo htmlspecialchars($_POST["username"]);
                                                                                                }
                                                                                            ?>">
            <input type="password" name="password" id="myPassword" required placeholder="şifreni yaz">
            <input type="checkbox" onclick="showPass()"> Şifreyi Göster
            <input type="submit" name="loginPost" value="giris yap" class="form-btn">
            <p><a href="../">siteye git</a></p>
        </form>
    </div>


    <script>
    function showPass() {
        const password = document.getElementById('myPassword')
        if (password.type === "password") {
            password.type = "text"
        } else {
            password.type = "password"
        }
    }
    </script>
</body>

</html>