<header class="masthead" style="background-image: url('assets/img/home-bg.jpg')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Mustafa.Blog</h1>
                    <span class="subheading">Full-Stack Developer'olmaya çalışıyo'</span>
                    <span class="fs6 fw-lighter">Yazılar deneme amaçlıdır</span>
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