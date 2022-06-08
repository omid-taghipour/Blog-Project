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
        <div class="links">
            <a href="newpost.php" class="btn btn-success float-right">Add a new Post</a>
        </div>
        <br><br>
        <hr>
        <?php
        include("db.php");

        $query = "SELECT post_id, title, content, upload_time, status FROM posts WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$_SESSION['user_id']]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$result) {
            echo '<div class="alert alert-warning" role="alert"><h1>You have added no post yet!</h1></div>';
        } else {
        ?>
            <table class="table table-light table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $counter = 1;
                    foreach($result as $index => $post){
                        echo '<tr?>';
                        echo '<th scope=""row>'.$counter.'</th>';
                        echo '<td scopt="row">'.$post['title'].'</td>';
                        echo '<td scopt="row">'.$post['status'].'</td>';
                        echo '<td scopt="row"><a class="btn btn-info" href="postinfo.php?id='.$post['post_id'].'">View post</a></td>';
                        echo '</tr>';
                        $counter++;
                    }
                    ?>
                </tbody>
            </table>
        <?php
        }
        ?>
    </div>
</body>

</html>