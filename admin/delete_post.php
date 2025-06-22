<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('../includes/config.php');

$id = $_GET['id'] ?? null;

if ($id) {
    // Delete image (optional, you can add)
    $res = $conn->query("SELECT image FROM posts WHERE id = $id");
    $imgData = $res->fetch_assoc();
    if ($imgData) {
        $imgPath = "../uploads/" . $imgData['image'];
        if (file_exists($imgPath)) {
            unlink($imgPath);
        }
    }

    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit();
?>
