<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Rejected posts</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">
        <?php
        @session_start();
        if (!isset($_SESSION['admin_id'])) {
            echo '<script>location.href="login.php"</script>';
        }
        ?>
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
                    } 
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <br>

    <div class="container">

<br>
        <?php
        include("db.php");

        $query = "SELECT post_id, title, content, upload_time, user_id FROM posts WHERE status = 'Rejected'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$result) {
            echo '<div class="alert alert-warning text-center" role="alert"><h1>There is no rejected post!</h1></div>';
        } else {
        ?>
        
        <h1>Pending posts for Approval are listed in the table below.</h1>
        <br>
            <table class="table table-light table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Writter</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $counter = 1;
                    foreach($result as $index => $post){
                        $sql = "SELECT full_name FROM users WHERE user_id = ?";
                        $stmt = $conn ->prepare($sql);
                        $stmt ->execute([$post['user_id']]);
                        $fullname = $stmt -> fetch(PDO::FETCH_ASSOC);
                        echo '<tr?>';
                        echo '<th scope=""row>'.$counter.'</th>';
                        echo '<td scopt="row">'.$post['title'].'</td>';
                        echo '<td scopt="row">'.$fullname['full_name'].'</td>';
                        echo '<td scopt="row"><a class="btn btn-info" href="admin-postinfo.php?id='.$post['post_id'].'">View post</a></td>';
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