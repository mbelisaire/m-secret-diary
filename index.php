<?php

session_start();

$link = mysqli_connect("localhost", "users", "Mada972/01", "users");

if(mysqli_connect_error()) {
    die ("<p>Connection Failed</p>");
}

$error = "";
$successMessage = "";

if($_SESSION['email'] OR $_COOKIE['customerEmail']) {
    header("Location: diary.php");
}

/** SIGN UP **/
if(array_key_exists('newemail', $_POST) OR array_key_exists('newpassword', $_POST)) {
    if(!empty($_POST["newemail"]) && !empty($_POST["newpassword"])) {

        /** UNIQUE EMAIL VERIF **/
        $email = "'".mysqli_real_escape_string($link, $_POST["newemail"])."'";
        $query = "SELECT id FROM `diary` WHERE email = $email";
        $result = mysqli_query($link, $query);
        if(mysqli_num_rows($result) > 0) {
            $error .= "<li>This email address is already registered.</li>";

        /** VERIF OK => SIGNING UP **/
        } else {
            $password = mysqli_real_escape_string($link, $_POST["newpassword"]);
            $hash = "'".password_hash($password, PASSWORD_DEFAULT)."'";
            $query = "INSERT INTO `diary` (`email`,`password`) VALUES ($email, $hash)";
            if(mysqli_query($link, $query)) {
                $_SESSION['email'] = $_POST['newemail'];
                if($_POST['newstay']) {
                    setcookie("customerEmail", $_POST['newemail'], time() + 60 * 60 * 24);
                }
                header("Location: diary.php");
            } else {
                $error .= "<li>There was a problem signing you up. Please, try again later.</li>";
            }
        }

    } else {
        if(empty($_POST["newemail"])) {
            $error .= "<li>Your email address is required.</li>";
        }
        if(empty($_POST["newpassword"])) {
            $error .= "<li>A password is required.</li>";
        }
    }


/** LOG IN **/
} else if(array_key_exists('email', $_POST) OR array_key_exists('password', $_POST)) {
    if(!empty($_POST["email"]) && !empty($_POST["password"])) {
        /** LOOK FOR EMAIL **/
        $email = "'".mysqli_real_escape_string($link, $_POST["email"])."'";
        $query = "SELECT * FROM `diary` WHERE email = $email";
        $result = mysqli_query($link, $query);
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $password = mysqli_real_escape_string($link, $_POST["password"]);
            /** CHECK PASSWORD **/
            if(password_verify($password, $row['password'])) {
                $_SESSION['email'] = $_POST['email'];
                if($_POST['stay']) {
                    setcookie("customerEmail", $_POST['newemail'], time() + 60 * 60 * 24);
                }
                header("Location: diary.php");
            } else {
                $error .= "<li>Wrong email address or/and password.</li>";
            }

        /** EMAIL NOT FOUND => NO LOG IN**/
        } else {
            $error .= "<li>Wrong email address or/and password.</li>";
        }
    } else {
        if(empty($_POST["email"])) {
            $error .= "<li>Your email address is required.</li>";
        }
        if(empty($_POST["password"])) {
            $error .= "<li>A password is required.</li>";
        }
    }
}

if(!empty($error)) {
    $error = "<div class='alert alert-danger' role='alert'><p><strong>There were error(s) in your form:</strong></p><ul>".$error."</ul></div>";
}

 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Secret Diary</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="stylesheet" href="diary.css" type="text/css">
    </head>
    <body>
        <div class="container">
            <h1 class="display-3">M. Secret Diary</h1>
            <p class="lead">Store your thoughts permanently and securely.</p>
            <p id="ad">Interested? Sign up now.</p>
            <div id="message"><? echo $error.$successMessage; ?></div>
            <form method="post" id="signUp">
                <input class="form-control" type="text" name="newemail" placeholder="Your Email" value="<? echo $_POST["newemail"]; ?>">
                <input class="form-control" type="password" name="newpassword" placeholder="Password">
                <label for="newStay"><input class="form-check-input" type="checkbox" name="newstay" id="newStay"> Stay Logged In</label>
                <div class="form-group"><button class="btn btn-success" type="submit" name="button">Sign Up!</button></div>
                <a id="goToLogIn" href="#">Log In</a>
            </form>
            <form method="post" class="hidden" id="logIn">
                <input class="form-control" type="text" name="email" placeholder="Your Email" value="<? echo $_POST["email"]; ?>">
                <input class="form-control" type="password" name="password" placeholder="Password">
                <label for="stay"><input class="form-check-input" type="checkbox" name="stay" id="stay"> Stay Logged In</label>
                <div class="form-group"><button class="btn btn-success" type="submit" name="button">Log In!</button></div>
                <a id="goToSignUp" href="#">Sign Up</a>
            </form>
            <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
            <script src="diary.js" type="text/javascript" charset="utf-8"></script>
        </div>
    </body>
</html>
