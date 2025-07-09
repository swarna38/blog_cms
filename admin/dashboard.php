<?php session_start();
    require_once '../config/connection.php';
    require_once '../includes/header.php';

?>



<h3 class="mb-3">All Posts</h3>
<p>
    <a href="add_post.php" class="btn btn-success mb-3">+ Add New Post</a>
</p>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($posts as $post): ?>
            <tr>
                <td><?= htmlspecialchars($post['title']) ?></td>
                <td><?= htmlspecialchars($post['author']) ?></td>
                <td><?= htmlspecialchars($post['category']) ?></td>
                <td><?= date('d M Y', strtotime($post['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php 
    require_once '../includes/footer.php';
?>