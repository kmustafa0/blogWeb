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
                <?php require_once "sidebar.php"; ?>
                <div class="col">
                    <div class="content">
                        <div class="container">
                            <center>
                                <h4 class="mt-5 mb-4 fs-1 fw-light">Kullanıcılar</h4>
                                <div class="mb-3">
                                    <input type="text" id="search" class="form-control" style="width: 300px;"
                                        placeholder="Arama yapın...">
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr class="text-center font-monospace">
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
                                                    $password = $row['password'];
                                                    $maskedPassword = str_repeat("*", strlen($password));
                                                    echo "<tr class='fw-lighter text-center'>";
                                                    echo "<td>" . $row["id"] . "</td>";
                                                    echo "<td>" . $row["name"] . "</td>";
                                                    echo "<td>" . $row["lastname"] . "</td>";
                                                    echo "<td>" . $row["phone"] . "</td>";
                                                    echo "<td>" . $row["email"] . "</td>";
                                                    echo "<td>" . $row["user_type"] . "</td>";
                                                    echo "<td>" . $row["username"] . "</td>";
                                                    echo "<td>" . $maskedPassword . "</td>";
                                                    echo "<td><a href='#' class='edit-btn btn btn-outline-info rounded fw-bold' data-user-id='" . $row["id"] . "' data-bs-toggle='modal' data-bs-target='#editModal'>Detaylar</a></td>";
                                                    echo "<td><a href='#' class='delete-user btn btn-outline-danger rounded fw-bold' data-id='" . $row["id"] . "'>Sil</a></td>";
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
                        <h5 class="fs-3 fw-light" id="editModalLabel">Kullanıcı Düzenle</h5>
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
                            <div class="mb-2">
                                <label for="editPassword" class="form-label">Şifre</label>
                                <input type="password" class="form-control" id="editPassword" name="password" required>
                                <label for="showPassword" class="fs-6">
                                    Şifreyi Göster<input type="checkbox" class="ms-1" name="showPassword"
                                        id="showPassword">
                                </label>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark"
                                    data-bs-dismiss="modal">Vazgeç</button>
                                <button type="submit" class="btn btn-outline-primary" id="saveChangesBtn"
                                    disabled>Kaydet</button>
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
                            location.reload();
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
        <script>
        document.getElementById('search').addEventListener('keyup', function(event) {
            const searchValue = event.target.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');

            tableRows.forEach(function(row) {
                const name = row.cells[1].innerText.toLowerCase();
                const lastname = row.cells[2].innerText.toLowerCase();
                const phone = row.cells[3].innerText.toLowerCase();
                const username = row.cells[6].innerText.toLowerCase();

                if (name.includes(searchValue) || lastname.includes(searchValue) || phone.includes(
                        searchValue) || username.includes(searchValue)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        const password = document.getElementById('editPassword');
        const checkbox = document.getElementById('showPassword');
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                password.type = 'text';
            } else {
                password.type = 'password';
            }
        });
        </script>
    </body>

    </html>
    <?php } ?>