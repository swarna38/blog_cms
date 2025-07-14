<?php session_start();
require_once '../config/connection.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
} else {

    $sql = $pdo->prepare("SELECT posts.*,
        users.name AS author, categories.name as category
        FROM posts
        LEFT JOIN users ON posts.user_id= users.id
        LEFT JOIN categories  ON posts.category_id = categories.id 
        ORDER BY posts.created_at DESC");

    $sql->execute();
    $posts = $sql->fetchAll();
}

?>


<h3 class="mb-3 fw-bold text-center mt-4">All Posts</h3>
<p class="text-center">
    <a href="add_post.php" class="btn btn-success mb-3">+ Add New Post</a>
</p>

<div class="table-responsive container">
    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($posts) { ?>
                <?php foreach ($posts as $post) { ?>
                    <tr>
                        <td><?= htmlspecialchars($post['title']) ?></td>
                        <td><?= htmlspecialchars($post['author']) ?></td>
                        <td><?= htmlspecialchars($post['category']) ?></td>
                        <td><?= date('d M Y', strtotime($post['created_at'])) ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4" class="text-center text-muted ">
                        You have no posts yet. <a href="add_post.php">Add one</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
require_once '../includes/footer.php';
?>