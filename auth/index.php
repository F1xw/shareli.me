<?php

session_start();

if (isset($_SESSION['loggedin']) || isset($_SESSION['uid'])) {
    header('location: /dashboard/?ref=auth');
}

$email = $passwd = '';
$email_err = $passwd_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['email_addr'])) {
        $email_err = 'Please enter your E-Mail adress.';
    }elseif(!isset($_POST['passwd'])){
        $passwd_err = 'Please enter your password.';
    }else{
        $passwd = $_POST['passwd'];
        $email_addr = $_POST['email_addr'];

        if (preg_match('/[\'^£$%&()}{~><>,|=_+¬-]/', $passwd)) {
            $passwd_err = 'Incorrect password.';
        }elseif(preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬-]/', $email_addr)){
            $email_err = 'No account found.';
        }

        $db_link = mysqli_connect('yeetlabs.de', 'shareli_me', 'Vrc41_z9', 'shareli_main');
        $query = "SELECT * FROM users WHERE email_addr = '$email_addr'";

        if (empty($passwd_err) && empty($email_err)) {
            if ($exec = mysqli_query($db_link, $query)) {
                if (mysqli_num_rows($exec) == 1) {
                    $data = mysqli_fetch_assoc($exec);
                    $encrypted_passwd = $data['passwd'];
                    $uid = $data['uid'];
                    $username = $data['username'];
                    $license = $data['pro_license'];

                    if (password_verify($passwd, $encrypted_passwd)) {

                        if ($_POST['rmbr'] == 'on') {
                            $idhash = $_COOKIE['IDHASH'];
                            setcookie('IDHASH', $idhash, strtotime('+1 year'), '/');
                        }

                        $_SESSION['loggedin'] = true;
                        $_SESSION['uid'] = $uid;
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $email;
                        $_SESSION['license'] = $license;

                        header('location: /');
                    }else{
                        $passwd_err = 'Incorrect password.';
                    }
                }else{
                    $email_err = 'No account found';
                }
            }else{
                echo '<div class="jumbotron bg-warning text-black"><h1>Error</h1><br><h4>Could not connect to database. Try again later!</h4></div>';
                exit;
            }
        }

    }
}

?>

<!DOCTYPE html>
<html style="width: 100%;height: 100%;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Login to your shareli.me account | shareli.me">
        <link rel="apple-touch-icon" sizes="180x180" href="/src/_ico/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/src/_ico/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="194x194" href="/src/_ico/favicon-194x194.png">
        <link rel="icon" type="image/png" sizes="192x192" href="/src/_ico/android-chrome-192x192.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/src/_ico/favicon-16x16.png">
        <link rel="manifest" href="/src/_ico/site.webmanifest">
        <link rel="mask-icon" href="/src/_ico/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="shortcut icon" href="/src/_ico/favicon.ico">
        <meta name="msapplication-TileColor" content="#2d89ef">
        <meta name="msapplication-config" content="/src/_ico/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" integrity="sha256-46qynGAkLSFpVbEBog43gvNhfrOj+BmwXdxFgVK/Kvc=" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="/src/ripple-btns/ripple.css">
        <link rel="stylesheet" href="/src/css/toast.css">
        <title>shareli.me - Log In</title>
    </head>
    <body>
        <div class="login-card">
            <img class="profile-img-card" src="assets/img/avatar_2x.png">
            <p class="profile-name-card"></p>
            <form class="form-signin" action="/auth/" method="post" class="login-form">
                <span class="reauth-email"></span>
                <input class="form-control login-input" name="email_addr" type="email" id="email_addr" required="" placeholder="E-Mail" autofocus="">
                <input class="form-control login-input" type="password" id="passwd" name="passwd" required="" placeholder="Password">
                <div class="checkbox">
                    <div class="form-check">
                        <input class="form-check-input login-input" type="checkbox" name="rmbr" id="rmbr">
                        <label class="form-check-label" for="formCheck-1">Remember me</label>
                    </div>
                </div>
                <button id="auth-submit" class="btn btn-primary btn-block btn-lg rpl-btn rpl-rounded login-submit" onclick="handleEvent();" style="margin-top:12px;margin-left:0px;height:50px;">Submit &nbsp;<i class="fas fa-arrow-right"></i></button>
            </form>
            <a class="forgot-password" href="#">Forgot your password?</a>
        </div>
        <canvas id="c"></canvas>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/1.0.0/anime.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>
        <script src="/src/ripple-btns/ripple.js"></script>
        <script src="/src/js/toast.js"></script>
        <script src="assets/js/bg.js"></script>
        <script src="assets/js/login.js"></script>
    </body>
</html>
