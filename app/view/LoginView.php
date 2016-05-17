<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<h1>
    <?php echo $Login ?>
</h1>
<a href="Registeration">REGISTERATION</a>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <input type="email" name="email" placeholder="EMAIL"><br>
    <?php
    if(isset($wrong)) {
        echo "<p class='redAlert'>" . $wrong . "</p>";
    }
    ?>
    <input type="password" name="password" placeholder="PASSWORD"><br>
    <input type="submit" value="LOG IN">
</form>
</body>
</html>