<?php include('includes/config.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>DevScoop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h1 class="text-center mb-4">DevScoop</h1>
        <div class="row g-4">
            <?php
            $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='col-md-4'>
                    <div class='card h-100 shadow'>
                        <img src='uploads/{$row['image']}' class='card-img-top' style='height:200px; object-fit:cover;'>
                        <div class='card-body'>
                            <h5 class='card-title'>".htmlspecialchars($row['title'])."</h5>
                            <p class='card-text'>".substr(strip_tags($row['content']), 0, 100)."...</p>
                            <a href='post.php?id={$row['id']}' class='btn btn-primary btn-sm'>Read More</a>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
