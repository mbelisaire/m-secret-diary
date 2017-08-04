<?php

session_start();

$link = mysqli_connect("localhost", "users", "Mada972/01", "users");

if(mysqli_connect_error()) {
    die ("<p>Connection Failed</p>");
}

if(!empty($_SESSION['email'])) {

    $email = "'".$_SESSION['email']."'";
    $query = "SELECT `diary` FROM diary WHERE email = $email";
    if($result = mysqli_query($link, $query)) {
        $row = mysqli_fetch_array($result);
        $content = $row['diary'];
    };

    if($_POST) {
        $content = "'".mysqli_real_escape_string($link, $_POST["content"])."'";
        $query = "UPDATE `diary` SET diary = $content WHERE email = $email LIMIT 1";
        mysqli_query($link, $query);
    }

} else {
    header("Location: index.php");
}

 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Secret Diary</title>
        <link rel="stylesheet" href="page.css" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid">
            <a href="logout.php">Log Out</a>
            <form>
                <textarea class="form-control" id="diaryPage" name="diary" rows="8" cols="80"><? echo $content; ?></textarea>
            </form>
        </div>
        <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <script src="diary.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
