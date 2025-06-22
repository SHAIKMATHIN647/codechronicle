<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('../includes/config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Admin Dashboard</h2>
        <a class="btn btn-success mb-3" href="add_post.php">+ Add New Post</a>
        <a class="btn btn-danger mb-3 float-end" href="logout.php">Logout</a>
        <table class="table table-bordered">
            <thead>
                <tr><th>Title</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['title']}</td>
                        <td>
                            <a href='edit_post.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='delete_post.php?id={$row['id']}' class='btn btn-sm btn-danger'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
