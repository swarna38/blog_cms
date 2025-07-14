<?php session_start();
require_once '../config/connection.php';
require_once '../includes/header.php';

$sql = $pdo->prepare("SELECT posts.*,
        categories.name AS category
        FROM posts
        LEFT JOIN categories ON posts.category_id=categories.id
        ORDER BY posts.created_at DESC
    ");
$sql->execute();
$posts = $sql->fetchAll();
?>



<div class="container">
        <h1 class="text-center text-uppercase fw-bold pt-2">show all information</h1>

    <div class="row text-center py-4">
        <?php foreach ($posts as $post) { ?>
            <div class="col-4">
                <div class="card border border-0 shadow p-4">
                    <div >

                    <h5>
                        <a class="" href="post.php?id=<?php echo htmlspecialchars($post['id']); ?>">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </a>
                    </h5>

                    <small>
                        Category:
                        <a href="category.php?cat=<?php echo htmlspecialchars($post['category_id']); ?>">
                            <!-- categories.name AS category -->
                            <?php echo htmlspecialchars($post['category']); ?>
                        </a>
                    </small>

                    <br>

                    <!-- check post not empty i mean image exists -->
                    <?php if ($post['image']) { ?>
                        <img class="img-fluid py-3" src="../uploads/post-images/<?= htmlspecialchars($post['image']); ?>" alt="No image">
                        <br>
                    <?php } ?>

                    <p><?php echo substr(strip_tags($post['content']), 0, 100) ?>...</p>

                    <a class="text-danger fw-bolder" href="post.php?id=<?= $post['id'] ?>">Read More</a>

                </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>




<?php
require_once '../includes/footer.php';
?>