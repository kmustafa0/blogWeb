<?php
/* function active($currect_page)
{
    $url_array = explode('/', $_SERVER['REQUEST_URI']);
    $url = end($url_array);
    if ($currect_page == $url) {
        echo 'active';
    }
} */
function active($currect_page)
{
    $url = $_SERVER['PHP_SELF'];
    if (strpos($url, $currect_page) !== false) {
        echo 'active';
    }
}
?>

<div class="col-md-2">
    <div class="sidebar">
        <!-- Sidebar içeriği -->
        <h1>MK | Blog</h1>
        <h6 class="text-black-50"><?php if (array_key_exists('user', $_SESSION)) {
                                        echo "giriş yapan: ", $_SESSION['user'];
                                    } else {
                                        echo "";
                                    } ?></h6>
        <ul class="nav flex-column gap-2">
            <li class="nav-item">
                <a class="nav-link <?php active('index'); ?> " href="index">Gönderi Paylaş</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php active('posts'); ?> " href="posts">Gönderiler</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php active('comments'); ?> " href="comments">Yorumlar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php active('users'); ?> " href="users">Kullanıcılar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php active('messages'); ?> " href="messages">Mesajlar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php active('footer'); ?> " href="footer">Footer</a>
            </li>
        </ul>
    </div>
</div>
<div class="col-md-2" style="position: fixed; bottom: 20px;">
    <a class="nav-link nav-link-quit text-danger" href="logout">Çıkış Yap</a>
</div>