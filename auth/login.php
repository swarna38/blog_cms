<?php session_start();
    require_once '../config/connection.php';
    require_once '../includes/header.php';

  if (isset($_SESSION['user_id'])) {
    // user already logged in → redirect to dashboard (not login again)
    header("Location: ../admin/dashboard.php");
    exit;
    }


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $email = htmlspecialchars(trim($_POST['email']));
        $password = trim($_POST['password']);

        $sql = $pdo->prepare("select * from users where email = ?");
        $sql->execute([$email]);
        $user = $sql->fetch();

        if($user && password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            header("Location: ../admin/dashboard.php");
            exit;
        }else{
            echo "Invalid email or password";
        }
    }

?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="min-width: 400px;">
        <h3 class="text-center mb-4">Login</h3>
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

        <p class="mt-3 text-center">
            Don't have an account? <a href="registration.php">Registration here</a>
        </p>
    </div>
</div>
<?php 
    require_once '../includes/footer.php';
?>