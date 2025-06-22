<?php include('includes/config.php'); ?>
<?php
$id = $_GET['id'] ?? null;
$result = $conn->query("SELECT * FROM posts WHERE id = $id");
$post = $result->fetch_assoc();
if (!$post) {
    echo "Post not found!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Home</a>
        <div class="card p-4 shadow">
            <h2><?= htmlspecialchars($post['title']) ?></h2>
            <img src="uploads/<?= $post['image'] ?>" class="img-fluid my-3" style="max-height:400px; object-fit:cover;">
            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        </div>
    </div>
</body>
</html>
