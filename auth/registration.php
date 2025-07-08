<?php session_start();

    include '../config/connection.php';
    include '../includes/header.php';

    $error= null;
    $success = null;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = trim($_POST['password']);
        $hass_password = password_hash($password, PASSWORD_DEFAULT);

        $sql= $pdo->prepare("select * from users where email= ?");
        $sql->execute([$email]);

        if($sql->fetch()){
            $error = 'Email already registered!';
        }else{
            $sql_insert = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $sql_insert->execute([$name, $email, $hass_password]);
            // $success = "Registration successful! Please login";
            header("Location:login.php");
            exit;
        }
    }
 
?>


<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="min-width: 400px;">
        <h3 class="text-center mb-4">Register</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Register</button>
        </form>

        <p class="mt-3 text-center">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>
</div>

<?php
    //if error or success set 
    if(isset($error)){
        echo "<p class='text-danger mt-2'>$error</p>";
    }
    if(isset($success)){
        echo "<p class='text-success mt-2'>$success</p>";
    }
 ?>

<?php 
    require_once '../includes/footer.php';
?>