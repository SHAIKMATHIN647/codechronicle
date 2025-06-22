<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('../includes/config.php');

$id = $_GET['id'] ?? null;

// Fetch current post
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    echo "Post not found!";
    exit();
}

// Handle update form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/" . $image);
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $content, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $id);
    }

    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Blog Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
    <div class="container">
        <h2>Edit Blog Post</h2>
        <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input name="title" value="<?= htmlspecialchars($post['title']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($post['content']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                <img src="../uploads/<?= $post['image'] ?>" width="200" class="mb-2"><br>
                <label class="form-label">Change Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Blog</button>
            <a href="dashboard.php" class="btn btn-secondary mt-2 w-100">Cancel</a>
        </form>
    </div>
</body>
</html>
