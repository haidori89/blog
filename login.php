<?php
require_once "app/functions.php";
session_start();
uConnected();
$err_email = "";
$err_pwd = "";
$msg = "";

if (isset($_POST['signin'])) {
    if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token']) {
        if (empty($_POST['email'])) {
            $err_email = "you must enter email";
        } elseif (empty($_POST['password'])) {
            $err_email = "you must enter password";
        } elseif (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $_POST['email'])) {
            $err_email = "please enter valid email";
        } else {  // checking email and password from the DB
            $link = db_connect();
            $email = sql_cleaner($_POST['email']);
            $password = sql_cleaner($_POST['password']);
            $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            $result = mysqli_query($link, $sql);
            if ($result && mysqli_num_rows($result) == 1) {
                $arr_data = mysqli_fetch_assoc($result);
                if (password_verify($password, $arr_data['pwd'])) {
                    session_start();
                    $_SESSION['name'] = $arr_data['name'];
                    $_SESSION['uid'] = $arr_data['id'];
                    $_SESSION['uip'] = $_SERVER['REMOTE_ADDR'];
                    msg_alert("success","sign in successfully");
                    header("location: index.php");
                } else {
                    $msg = "username or password are inccorect";
                }
            } else {
                $msg = "username or password are inccorect";
            }
        }
    }
}
$token = tokens();
$_SESSION['token'] = $token;
?>
<?php
require_once "tpl/header.php";
if(isset($_GET['redicet'])&&$_GET['redicet']=="logout" && $_SESSION['redicet'] == true){
    msg_stop();
    $_SESSION['redicet'] = false;
}
?>
<div class="container text-center">
    <div class="login-form">
        <form action="" method="post">
            <h2 class="text-center">Sign in</h2>
            <div class="form-group">
                <span class="err"><?= $msg; ?></span>
                <span class="err"><?= $err_email; ?></span>
                <input type="text" class="form-control" placeholder="Email" name="email" required="required">
            </div>
            <div class="form-group">
                <span class="err"><?= $err_pwd; ?></span>
                <input type="password" class="form-control" placeholder="Password" required="required" name="password">
            </div>
            <input type="hidden" name="token" value="<?= $token; ?>">
            <div class="form-group">
                <button name="signin" type="submit" class="btn btn-primary btn-large">Log in</button>
            </div>
            <p class="text-center signup">not registred yet? <a href="signup.php">Create an Account</a></p>
        </form>

    </div>
</div>


<?php
require_once "tpl/footer.php";

?>