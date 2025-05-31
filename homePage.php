<?php
session_start();
//If user is set (not empty) it will store inside a session
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}else {
    header('Location: signin.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <div class="main_page">
            <div class="main_content">
                <h1>You have successfully logged in!</h1>
                <p>Welcome user <?php echo $user['name']?></p>
            </div>
            <div class="log-out_container">
                <a href="logout.php">Log out</a>
            </div>
        </div>
    </main>
</body>
</html>