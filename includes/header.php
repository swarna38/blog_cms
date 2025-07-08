<?php session_start();

if(isset($_SESSION['user_id'])){
    header('Location: ../auth/login.php');
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blog Admin Panel</title>
    <!-- ====bootstrap link==== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<h2>Welcome, <?php echo $_SESSION['user_name'] ?>  
    <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
</h2>