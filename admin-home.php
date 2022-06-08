<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Admin Dashboard</title>
</head>

<body>
    <?php
    @session_start();
    if (!isset($_SESSION['admin_id'])) {
        header("location: login.php");
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
        <br><br>
        <?php
        include("db.php");
        $sql = "SELECT * FROM posts WHERE status = 'Approved' ORDER BY upload_time DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            foreach ($result as $index => $post) {
                $sql = "SELECT full_name FROM users WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$post['user_id']]);
                $writername = $stmt->fetch(PDO::FETCH_ASSOC);
                echo '<div class="card">
                    <h5 class="card-header">' . strtoupper($post['title']) . '<small><em>, from ' . $writername['full_name'] . ' <span class="float-right">' . $post['upload_time'] . '</span></em></small></h5>';
                echo '<div class="card-body">
                      <h5 class="card-title">' . strtoupper($post['title']) . '</h5>
                      <p class="card-text">' . $post['content'] . '</p>
                      <a href="admin-postinfo.php?id='.$post['post_id'].'" class="btn btn-primary">View post</a>
                    </div>
                  </div><br><br>';
            }
        } else {
            echo '<div class="alert alert-warning" role="alert">
                <h2 class="text-center">Currently, there is no post available!</h2>
              </div>';
            echo '<div class="d-grid gap-2"><a href="newpost.php" class="btn btn-info btn-lg ">Create a new post</a></div>';
        }

        ?>
    </div>
</body>

</html>