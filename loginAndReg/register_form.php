<?php

@include '../config.php';

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $pass = $_POST['password'];
   $cpass = $_POST['cpassword'];

   $select = " SELECT * FROM users WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {

      $error[] = 'user already exist!';
   } else {

      if ($pass != $cpass) {
         $error[] = 'password not matched!';
      } else {
         $insert = "INSERT INTO `users`(
            `name`,
            `lastname`,
            `phone`,
            `email`,
            `username`,
            `password`
        )
        VALUES(
            '$name',
            '$lastname',
            '$phone',
            '$email',
            '$username',
            '$pass'
        )";
         mysqli_query($conn, $insert);
         header('location:login.php');
      }
   }
};


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ekranı</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="form-container">

        <form action="" method="post">
            <h3>Kayıt ol</h3>
            <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            };
         };
         ?>
            <input type="text" name="name" required placeholder="adın">
            <input type="text" name="lastname" required placeholder="soyadın">
            <input type="text" name="phone" required placeholder="telefonun">
            <input type="email" name="email" required placeholder="email adresin">
            <input type="text" name="username" required placeholder="kullanıcı adın">
            <input type="password" name="password" required placeholder="şifren">
            <input type="password" name="cpassword" required placeholder="şifreni onayla">
            <input type="submit" name="submit" value="kayıt ol" class="form-btn">
            <p>kullanıcı hesabın var mı? <a href="login.php">giriş yap</a></p>
        </form>

    </div>

</body>

</html>