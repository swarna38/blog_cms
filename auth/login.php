<?php session_Start();
    require_once '../config/connection.php';
    require_once '../includes/header.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
    }

?>

<form method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Email address:</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
</form>
<p><a href="register.php">Create an account</a></p>

<?php 
    require_once '../includes/footer.php';
?>