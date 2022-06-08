<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Admin Login</title>
</head>

<body>
    <?php
    if (isset($_POST['sbt'])) {
        $usname = $_POST['username'];
        $pwd = $_POST['password'];

        require("db.php");

        $sql = 'SELECT admin_id, full_name FROM admins WHERE username = ? AND password = ?';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$usname, $pwd]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            @session_start();
            $_SESSION['admin_id'] = $result['admin_id'];
            $_SESSION['full_name'] = $result['full_name'];
            echo '<script>location.href="admin-home.php";</script>';
        } else
            echo '<script>alert("Username or Password is incorrect!")</script>';
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="admin-home.php">327Blogs</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <?php
                    if (isset($_SESSION['admin_id'])) {
                        echo '<li class="nav-item active">
                        <a class="nav-link" href="pending-posts.php"">Pending posts<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="rejected-posts.php"">Rejected posts<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="logout.php"">Logout<span class="sr-only">(current)</span></a>
                    </li>';
                    } else {
                        echo '<li class="nav-item active">
                        <a class="nav-link " href="admin-login.php">Login<span class="sr-only">(current)</span></a>
                    </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="jumbotron">
            <h1 class="text-center">Login to your Admin account</h1>
            <p>Please use the form below to login in.</p>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Enter your username: </label>
                <input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your username...">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Enter your password: </label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Enter your password...">
            </div>
            <button type="submit" name="sbt" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>

</html>