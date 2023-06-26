# Blog sitem. Geliştirmeye devam ediyorum

### Ornek config dosyası aşağıdaki gibidir.

### PHPMailer'ı kullanabilmeniz için .env dosyasına google mail adresinizi ve google'dan oluşturduğunuz uygulama şifrenizi yazmanız gerekiyor.

<br>
Ornek .env dosyası
<br>
MAIL = mail_adresiniz <br>
PASSWORD = uygulama_şifreniz

<br>

Ornek config.php dosyası
<br>
`<?php` <br>
&emsp;`$hostname = 'hostname';` <br>
&emsp;`$username = 'username';` <br>
&emsp;`$password = 'password';` <br>
&emsp;`$db = 'db';`
&emsp;`$conn = new mysqli($hostname, $username, $password, $db);` <br>
&emsp;`if ($conn->connect_error) {` <br>
&emsp;&emsp;`die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);` <br>
`}`

## [Siteye buradan gidebilirsiniz](https://blog.mustafakole.dev)
