<?php session_start();
    require_once '../config/connection.php';
    require_once '../includes/header.php';

    if(!isset($_SESSION['user_id'])){
        header("Location: ../auth/login.php");
        exit;
    }

    $sql = $pdo->query("SELECT * FROM categories");
    $categories = $sql->fetchAll();

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $title = trim( $_POST['title']);
        $content = trim($_POST['content']);
        $category = $_POST['category'];
        $image = '';

        // image upload
        if(!empty($_FILES['image']['name'])){

            // file type
            $allow_file_type = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $file_size =2 * 1024 * 1024;

            //check file type does not match
            if (!in_array($_FILES['image']['type'], $allow_file_type)){
                die("file type does not match give me jpeg jpg png or gif");
            }

            //check file size 
            if ($_FILES['image']['size'] > $file_size) {
                die("large file not allow just allow 2mb file");
            }

            //unique file name
            $unique_file_name = uniqid(). '_' . $_FILES['image']['name'];
            $image = $unique_file_name;
            $upload_path = '../uploads/post-images/' . $image;
            $tmp_path = $_FILES['image']['tmp_name'];

            //pic upload server
            if(!move_uploaded_file($tmp_path, $upload_path)){
                die("Image upload failed.");
            }
        }
         $sql= $pdo->prepare("INSERT INTO posts (user_id, category_id, title, content, image) VALUES (?, ?, ?, ?, ?)");
            $results = $sql->execute([$_SESSION['user_id'],
                $category,
                $title,
                $content,
                $image]
            );

            if($results){
                header("Location: dashboard.php");
            }else{
                echo "<p style='color:red'>Failed to add post!</p>";
            }
    }
?>




<h3 class="mb-4">Add New Post</h3>

<form method="POST" enctype="multipart/form-data" class="container" style="max-width: 600px;">
    <div class="mb-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content:</label>
        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
    </div>

    <div class="mb-3">
        <label for="category" class="form-label">Category:</label>
        <select class="form-select" id="category" name="category" required>
            <?php foreach ($categories as $cat){ ?>
                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image:</label>
        <input class="form-control" type="file" id="image" name="image">
    </div>

    <button type="submit" class="btn btn-primary">Add Post</button>
</form>

<?php 
    require_once '../includes/footer.php';
?>