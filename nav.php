<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="/blogWeb">Mustafa.Blog</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto py-4 py-lg-0">
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/blogWeb">ANA SAYFA</a></li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/blogWeb/about">Hakkımda</a></li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/blogWeb/contact">İletişim</a></li>
                <li class="nav-item">
                    <?php
                    session_start();

                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        echo '<a href="/blogWeb/loginAndReg/logout" class="nav-link px-lg-3 py-3 py-lg-4">Çıkış
                            yap</a>';
                    } else {
                        echo '<a class="nav-link px-lg-3 py-3 py-lg-4" href="/blogWeb/loginAndReg/login">Giriş
                            Yap</a>';
                    }
                    ?>

                </li>
            </ul>
        </div>
    </div>
</nav>