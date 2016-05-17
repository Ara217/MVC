<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h1>HOME</h1>
    <a href="Login">LOGIN</a>
    <h3><?php echo "WELCOM " . $name . " " .  $lastname; ?></h3>
    <p><?php echo "Your Email is " . $email; ?></p>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <input type="submit" name="logout" value="LOG OUT">
    </form>
</body>
</html>