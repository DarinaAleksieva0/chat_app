<?php
session_start();

if (!isset($_SESSION['username'])) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App - Login</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="images/logo.png">

</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-400 p-5 shadow rounded">
        <form method="post" action="app/http/auth.php">
            <div class="d-flex justify-content-center align-items-center flex-column">

            <img src="images/logo.png" class="w-25" alt="this is the logo">
            <h3 class="title">Login</h3>  
            </div>

            <?php if(isset($_GET['error'])) { ?>
            <div class="alert alert-warning" role="alert">
               <?php echo htmlspecialchars($_GET['error']);?>
            </div>
            <?php } ?>


            <?php if(isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
               <?php echo htmlspecialchars($_GET['success']);?>
            </div>
            <?php } ?>


            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>

            <button type="submit" class="btn btn-primary">Login</button>

            <a href="signup.php"> SignUp</a>
        </form>
    </div>
</body>

</html>
<?php
} else {
    header("Location: home.php");
    exit;
}
?>