<?php session_start();
require_once '../config/connection.php';
require_once '../includes/header.php';

// check if id not set get method
if (!isset($_GET['id'])) {
    echo "Invalid post.";
    include "../includes/footer.php";
    exit;
}

//include get id from index page
$id = $_GET['id'];

$sql = $pdo->prepare("SELECT posts.*,
    categories.name AS category FROM posts 
    LEFT JOIN categories
    ON posts.category_id = categories.id 
    WHERE posts.id = ?");

$sql->execute([$id]);
$post = $sql->fetch();

if (!$post) {
    echo "<p style='color:red'>Post not found.</p>";
    require_once '../includes/footer.php';
    exit;
}

?>


<div class="container">
    <div class="row py-4">
        <div class="col-6 mx-auto shadow p-3">
            <h2 class="fw-bolder"><?php echo htmlspecialchars($post['title']) ?></h2>
            <small>
                category:
                <?php echo $post['category'] ?> <br>
                posted on:
                <?php echo date('d M Y', strtotime($post['created_at'])) ?>
            </small>

            <?php if ($post['image']) { ?>

                <img class="img-fluid shadow-sm py-3" src="../uploads/post-images/<?= htmlspecialchars($post['image']); ?>" alt="No image">
            <?php } ?>

            <p><?php echo htmlspecialchars($post['content']) ?></p>
        </div>
    </div>
</div>


<?php
require_once '../includes/footer.php';
?>