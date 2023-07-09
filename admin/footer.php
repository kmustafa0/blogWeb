<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login");
} else {
    include "../config.php";
?>

<!DOCTYPE html>
<html lang="en">

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
                <center>
                    <div class="container">
                        <h1 class="my-4">Footer Icons Admin Panel</h1>

                        <!-- Icon List -->
                        <div class="mb-4">
                            <h3>Icon List</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Icon</th>
                                        <th>Link</th>
                                        <th>Footer Text</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Placeholder table rows for demonstration -->
                                    <tr>
                                        <td><i class="fab fa-facebook"></i></td>
                                        <td>https://www.facebook.com/your_page</td>
                                        <td>This is my footer text.</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">Edit</button>
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Add/Edit Form -->
                        <div>
                            <h3>Add/Edit Icon</h3>
                            <form>
                                <div class="mb-3">
                                    <label for="iconClass" class="form-label">Icon Class</label>
                                    <input type="text" class="form-control" id="iconClass"
                                        placeholder="E.g., fab fa-facebook" required>
                                </div>
                                <div class="mb-3">
                                    <label for="link" class="form-label">Link</label>
                                    <input type="text" class="form-control" id="link"
                                        placeholder="E.g., https://www.facebook.com/your_page" required>
                                </div>
                                <div class="mb-3">
                                    <label for="footerText" class="form-label">Footer Text</label>
                                    <input type="text" class="form-control" id="footerText"
                                        placeholder="E.g., This is my footer text." required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>

                    </div>
                </center>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php } ?>