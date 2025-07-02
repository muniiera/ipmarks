<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';
$full_name = $_SESSION['full_name'];
$user_level = $_SESSION['user_level'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="js/load_supervisors.js"></script>

</head>

<body>
    <div class="container mt-5">
        <h2>Welcome, <?php echo $full_name; ?>!</h2>
        <h4>Your Role: <?php echo $user_level; ?></h4>

        <ul class="list-group mt-3">
            <?php
            switch ($user_level) {
                case 'Admin':
                    echo "<li class='list-group-item'><a href='admin.php'>Admin Panel</a></li>";
                    break;
                case 'Unit Project':
                    echo "<li class='list-group-item'><a href='unit_project.php'>Unit Project Page</a></li>";
                    break;
                case 'Panel Demo 3':
                    echo "<li class='list-group-item'><a href='panel_demo.php'>Panel Demo Page</a></li>";
                    break;
                case 'Panel Booth':
                    echo "<li class='list-group-item'><a href='panel_booth.php'>Panel Booth Page</a></li>";
                    break;
                case 'Panel Innovation':
                    echo "<li class='list-group-item'><a href='panel_innovation.php'>Panel Innovation Page</a></li>";
                    break;
            }
            ?>
        </ul>

        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>
</body>

</html>