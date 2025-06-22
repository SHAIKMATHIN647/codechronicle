<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('../includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $temp = $_FILES['image']['tmp_name'];
    $target = "../uploads/" . $image;

    if (move_uploaded_file($temp, $target)) {
        $stmt = $conn->prepare("INSERT INTO posts (title, content, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $image);
        $stmt->execute();
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Image upload failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Blog Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
    <div class="container">
        <h2 class="mb-4">Add New Blog Post</h2>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" rows="6" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Publish Blog</button>
            <a href="dashboard.php" class="btn btn-secondary mt-2 w-100">Cancel</a>
        </form>
    </div>
</body>
</html>
