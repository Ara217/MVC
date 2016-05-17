<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h1>
        <?php echo $Registeration; ?>
    </h1>
    <a href="Login">LOGIN</a>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <input type="text" name="name" placeholder="NAME"><br>
        <input type="text" name="lastname" placeholder="LASTNAME"><br>
        <input type="email" name="email" placeholder="EMAIL"><br>
        <input type="password" name="password" placeholder="PASSWORD"><br>
        <?php
        if(isset($wrong)) {
            echo "<p class='redAlert'>" . $wrong . "</p>";
        }
        ?>
        <input type="submit" value="SIGN UP">
    </form>

</body>
</html>

