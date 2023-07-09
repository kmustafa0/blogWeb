<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>MK | Blog</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800"
        rel="stylesheet" type="text/css" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require_once 'nav.php' ?>
    <?php require_once 'header.php' ?>
    <?php
        require_once 'config.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $created_at = date('Y-m-d H:i:s');

            $sql = "INSERT INTO messages (email, subject, message, created_at) VALUES (?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $email, $subject, $message, $created_at);

            if ($stmt->execute()) {
                $successMessage = "Mesajınız başarılı bir şekilde gönderildi.";
                $_POST = array();
            } else {
                $errorMessage = "Mesaj gönderilirken bir hata oluştu: " . $stmt->error;
            }

            $stmt->close();
        }
    ?>

    <main class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <p>İletişime geçmek ister misiniz? Bana mesaj göndermek için aşağıdaki formu doldurun, en kısa
                        sürede size geri döneceğim!</p>
                    <div class="my-5">
                        <div id="successMessage" class="alert alert-success" role="alert" style="display: none;"></div>
                        <div id="errorMessage" class="alert alert-danger" role="alert" style="display: none;"></div>
                        <form id="contactForm" method="post">
                            <div class="form-floating">
                                <input class="form-control" id="email" type="email" name="email" placeholder="a"
                                    required />
                                <label for="email">E-posta Adresin</label>
                            </div>
                            <div class="form-floating">
                                <input class="form-control" id="subject" type="text" name="subject" placeholder="a"
                                    required />
                                <label for="subject">Mesajınızın Konusu</label>
                            </div>
                            <div class="form-floating">
                                <input class="form-control" id="message" type="text" name="message" placeholder="a"
                                    required style="height:12rem;">
                                <label for="message">Mesajın</label>
                            </div>
                            <br />
                            <button class="btn btn-primary text-uppercase" id="submitButton" type="submit"
                                name="send">Gönder</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <?php require_once'footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script>
    // Otomatik mesaj kapatma fonksiyonu
    function hideMessage() {
        var successMessage = document.getElementById('successMessage');
        var errorMessage = document.getElementById('errorMessage');

        if (successMessage) {
            successMessage.style.display = 'none';
        }

        if (errorMessage) {
            errorMessage.style.display = 'none';
        }
    }

    // Başarılı veya hatalı mesajları görüntüleme
    <?php if (isset($successMessage)): ?>
    document.getElementById('successMessage').innerHTML = '<?php echo $successMessage; ?>';
    document.getElementById('successMessage').style.display = 'block';
    setTimeout(hideMessage, 1000);
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
    document.getElementById('errorMessage').innerHTML = '<?php echo $errorMessage; ?>';
    document.getElementById('errorMessage').style.display = 'block';
    setTimeout(hideMessage, 1000);
    <?php endif; ?>
    </script>
</body>

</html>