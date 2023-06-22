<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
} else {

    include "../config.php";

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MK | Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="./css/sidebar.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="sidebar">
                    <!-- Sidebar içeriği -->
                    <h1>MustafaK</h1>
                    <h6 class="text-black-50"><?php if (array_key_exists('user', $_SESSION)) {
                                                echo "giriş yapan: ",$_SESSION['user'];
                                            } else {
                                                echo "";
                                            }?></h6>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Gönderi Paylaş</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="posts.php">Gönderiler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="comments.php">Yorumlar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="users.php">Kullanıcılar</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2" style="position: fixed; bottom: 20px;">
                <a class="nav-link nav-link-quit" href="logout.php">Çıkış Yap</a>
            </div>
            <div class="col">
                <div class="content">
                    <div class="container">
                        <center>
                            <h4 class="mt-5 mb-4">Kullanıcılar</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ad</th>
                                        <th>Soyad</th>
                                        <th>Telefon</th>
                                        <th>E-posta</th>
                                        <th>Kullanıcı Türü</th>
                                        <th>Kullanıcı Adı</th>
                                        <th>Şifre</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                $sql = "SELECT * FROM users";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["id"] . "</td>";
                                        echo "<td>" . $row["name"] . "</td>";
                                        echo "<td>" . $row["lastname"] . "</td>";
                                        echo "<td>" . $row["phone"] . "</td>";
                                        echo "<td>" . $row["email"] . "</td>";
                                        echo "<td>" . $row["user_type"] . "</td>";
                                        echo "<td>" . $row["username"] . "</td>";
                                        echo "<td>" . $row["password"] . "</td>";
                                        echo "<td><a href='#' class='edit-btn bg-gray' data-user-id='" . $row["id"] . "' data-bs-toggle='modal' data-bs-target='#editModal'>Düzenle</a></td>";
                                        echo "<td><a href='#' class='delete-user bg-gray' data-id='" . $row["id"] . "'>Sil</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>Kullanıcı bulunamadı.</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </center>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Düzenleme Modalı -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Kullanıcı Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editUserId" name="id">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Ad</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLastname" class="form-label">Soyad</label>
                            <input type="text" class="form-control" id="editLastname" name="lastname" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">Telefon</label>
                            <input type="text" class="form-control" id="editPhone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">E-posta</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserType" class="form-label">Kullanıcı Türü</label>
                            <select class="form-select" id="editUserType" name="user_type" required>
                                <option value="admin">Admin</option>
                                <option value="user">Kullanıcı</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Kullanıcı Adı</label>
                            <input type="text" class="form-control" id="editUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Şifre</label>
                            <input type="password" class="form-control" id="editPassword" name="password" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                            <button type="submit" class="btn btn-primary" id="saveChangesBtn" disabled>Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        $(".edit-btn").click(function() {
            var userId = $(this).data("user-id");
            $.ajax({
                url: "get_user.php",
                method: "POST",
                data: {
                    id: userId
                },
                dataType: "json",
                success: function(response) {
                    $("#editUserId").val(response.id);
                    $("#editName").val(response.name);
                    $("#editLastname").val(response.lastname);
                    $("#editPhone").val(response.phone);
                    $("#editEmail").val(response.email);
                    $("#editUserType").val(response.user_type);
                    $("#editUsername").val(response.username);
                    $("#editPassword").val(response.password);
                }
            });
        });

        $("#editForm input, #editForm select").change(function() {
            $("#saveChangesBtn").prop("disabled", false);
        });

        $("#editForm").submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "update_user.php",
                method: "POST",
                data: formData,
                success: function() {
                    location.reload();
                }
            });
        });
    });
    </script>
    <script>
    $(document).on("click", ".delete-user", function() {
        var userId = $(this).data("id");
        if (confirm("Kullanıcıyı silmek istediğinize emin misiniz?")) {
            $.ajax({
                url: "delete_user.php",
                type: "POST",
                data: {
                    id: userId
                },
                success: function(response) {
                    if (response == "success") {
                        $("tr[data-id='" + userId + "']").remove();
                    } else {
                        alert("Kullanıcı silinirken bir hata oluştu.");
                    }
                },
                error: function() {
                    alert("İstek gönderilirken bir hata oluştu.");
                }
            });
        }
    });
    </script>
</body>

</html>
<?php } ?>