<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">
        <?php
        @session_start();
        if (!isset($_SESSION['user_id'])) {
            echo '<script>location.href="login.php"</script>';
        }
        ?>
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
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Title of the post: </label>
                <input type="text" class="form-control" name="title" placeholder="Enter the title...">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Content of the post: </label>
                <textarea class="form-control" name="content" placeholder="Enter the content..." rows="15"></textarea>
            </div>
            <button type="submit" class="btn btn-success" name="sbt">Save</button>
        </form>
    </div>
</body>

</html>
<?php 
    if(isset($_POST['sbt'])){
        include("db.php");
        $title = $_POST['title'];
        $content = $_POST['content'];

        $sql = "INSERT INTO posts(user_id, title, content) VALUES(?,?,?)";
        $stmt = $conn ->prepare($sql);
        if($stmt -> execute([$_SESSION['user_id'], $title, $content])){
            echo '<script>alert("Post is saved."); location.href="myposts.php"</script>';
        }
    }
?>
