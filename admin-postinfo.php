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
        <?php
        include("db.php");
        if (isset($_POST['approveBtn'])) {
            $post_id = $_POST['post_id'];
            $sql = "UPDATE posts SET status = ? WHERE post_id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute(['Approved', $post_id])) {
                echo '<script>alert("Post has been approved!"); location.href="pending-posts.php";</script>';
            }
        } else if (isset($_POST['rejectBtn'])) {
            $post_id = $_POST['post_id'];
            $sql = "UPDATE posts SET status = ? WHERE post_id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute(['Rejected', $post_id])) {
                echo '<script>alert("Post has been rejected!"); location.href="pending-posts.php";</script>';
            }
        } else {
            $post_id = $_GET['id'];
        }

        $query = "SELECT * FROM posts WHERE post_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$post_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT full_name FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$result['user_id']]);
        $fullname = $stmt->fetch(PDO::FETCH_ASSOC);

        ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <figure>
                <blockquote class="blockquote">
                    <h2>
                        <p>Post Information</p>
                    </h2>
                </blockquote>
                <figcaption class="blockquote-footer">
                    <cite>This post created at <?php echo $result['upload_time'] . ' by <b>' . $fullname['full_name'] . '</b>'; ?></cite>
                </figcaption>
            </figure>
            <h1></h1><br>
            <small><em></em></small>
            <div class="alert alert-info" role="alert">
                Curret status of this post is <b><?php echo $result['status']; ?></b>
            </div>
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $result['title']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Content</label>
                <textarea type="text" class="form-control" name="content" rows="15" readonly><?php echo $result['content']; ?></textarea>
            </div>
            <button type="submit" name="approveBtn" class="btn btn-success">Approve the post</button> &nbsp;
            <button type="submit" name="rejectBtn" class="btn btn-danger">Reject the post</button> &nbsp;

        </form>

    </div>

    <br><br><br>

</body>

</html>

<?php

?>