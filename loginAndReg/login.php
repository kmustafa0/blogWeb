<?php

include "../config.php";


if (isset($_POST['submit'])) {
   session_start();
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);
   $select = " SELECT * FROM users WHERE email = '$email' && password = '$pass' ";
   $result = mysqli_query($conn, $select);
   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result);
      if ($row['user_type'] == 'admin') {
         $_SESSION['id'] = $row['id'];
         $_SESSION['usertype'] = $row['user_type'];
         $_SESSION['name'] = $row['name'];
         $_SESSION['username'] = $row['username'];
         $_SESSION['loggedin'] = true;
         header('location:../index.php');
      } elseif ($row['user_type'] == 'user') {
         $_SESSION['id'] = $row['id'];
         $_SESSION['name'] = $row['name'];
         $_SESSION['username'] = $row['username'];
         $_SESSION['loggedin'] = true;
         header('location:../index.php');
      }
   } else {
      $error[] = 'incorrect email or password!';
   }
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giriş Ekranı</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <div class="form-container">
      <form action="" method="post">
         <h3>Giriş Yap</h3>
         <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            };
         };
         ?>
         <input type="email" name="email" required placeholder="email adresini yaz">
         <input type="password" name="password" id="myPassword" required placeholder="şifreni yaz">
         <input type="checkbox" onclick="showPass()"> Şifreyi Göster
         <input type="submit" name="submit" value="giris yap" class="form-btn">
         <p>hesabın yok mu? <a href="register_form.php">kayıt ol</a></p>
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