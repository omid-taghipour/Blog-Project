<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Login</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">327Blogs</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <?php
                    if (isset($_SESSION['userid'])) {
                        echo '<li class="nav-item active">
                        <a class="nav-link" href="logout.php"">Logout<span class="sr-only">(current)</span></a>
                    </li>';
                    } else {
                        echo '<li class="nav-item active">
                        <a class="nav-link " href="login.php">Login<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                    <a class="nav-link " href="signup.php">Sign up<span class="sr-only">(current)</span></a>
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
            <h1 class="text-center">Login to your account</h1>
            <p>Please use the form below to login in.</p>
            <pre>Your username is your email address</pre>
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

<?php
if (isset($_POST['sbt'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    require("db.php");
    // $sql = 'SELECT * FROM users WHERE user_name = "$username" AND user_password = "$password"';
    // $stmt = $conn->prepare($sql);
    // $stmt->execute();
    // $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // if ($result){
    //     echo '<script>location.href="index.html";</script>';
    // } else{
    //     echo 'No';

    $query = 'SELECT user_id, user_fullname
                FROM users 
                WHERE user_name=? and user_password=?';

    $stmt = $conn->prepare($query);
    $stmt->execute([$username, $password]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        echo '<script>alert(' . gettype($_SESSION['userid']) . ');</script>';
    } else{
        echo "no";
    }
}
?>