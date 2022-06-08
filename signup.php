<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Sign up</title>
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
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        echo '<li class="nav-item active">
                        <a class="nav-link" href="myposts.php"">My posts<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
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
            <h1 class="text-center">Sign up to blog application</h1>
            <p>Please fill the form below to sign up in the system.</p>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">User Name:</label>
                <input type="text" name="username" class="form-control" placeholder="Enter your username...">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password: </label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your password...">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Full Name: </label>
                <input type="text" name="fullname" class="form-control" id="exampleInputPassword1" placeholder="Enter your full name...">
            </div>

            <button type="submit" name="sbt" class="btn btn-primary">Submit</button>
            <br><br>
        </form>
    </div>
</body>

</html>


<?php
if (isset($_POST['sbt'])) {
    $usname = $_POST['username'];
    $pwd = $_POST['password'];
    $fullname = $_POST['fullname'];
    include("db.php");
    try {
        $query = "INSERT INTO users(username, full_name, password) VALUES (?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$usname, $fullname, $pwd]);
    } catch (Exception $e) {
        echo "Insertion failed!";
    }
}
?>