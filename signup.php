<?php
require_once "app/functions.php";
session_start();
uConnected();
$err_name = "";
$err_email = "";
$err_pwd = "";
$err_re_pwd = "";
require_once "app/classes.php";
$old_vals = new vals();

if(isset($_POST['signup'])){
    if(isset($_POST['token']) && $_POST['token'] == $_SESSION['token'] ){
    if(empty($_POST['name'])){
        $err_name = "you must enter name";
    }elseif(empty($_POST['email']))
    {
        $err_email = "you must enter email";
    }
    elseif(empty($_POST['password']))
    {
        $err_pwd = "you must enter password";
    }
    elseif(empty($_POST['re_password']))
    {
        $err_pwd = "you must re enter the password";
    }
        elseif(!preg_match("/^([a-z]{2,25})$/i", $_POST['name']))
    {
        $err_name = "name must be between 2-25 characters only";
    }
    elseif(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $_POST['email']))
    {
        $val_name = htmlspecialchars($_POST['name']); 
        $err_email = "you must enter valid email";
    }
    elseif($_POST['password'] != $_POST['re_password'])
    {
        $val_name = htmlspecialchars($_POST['name']); 
        $val_email = htmlspecialchars($_POST['email']); 
        $err_pwd = "passwords does not match";
    }
    elseif(!preg_match('/^[0-9A-Za-z!@#$%]{6,25}$/', $_POST['password']))
    {
        $val_name = htmlspecialchars($_POST['name']); 
        $val_email = htmlspecialchars($_POST['email']); 
        $err_pwd = "password must be 6-25 digits and characters";

    }
    else{
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $link = db_connect();
        $name = mysqli_real_escape_string($link,$name);
        $email = mysqli_real_escape_string($link,$email);
        $password = mysqli_real_escape_string($link,$password);
        $sql_mail_check = "SELECT email from users WHERE email = '$email'";
        $result = mysqli_query($link,$sql_mail_check);
        
        if($result && mysqli_num_rows($result)>0){  // check if mail is exist
            $val_name = htmlspecialchars($_POST['name']);
            $err_email = "email is already in use";
        }else{ // add new user to db
            $password = password_hash($password, PASSWORD_BCRYPT);
            $sql_add_user = "INSERT INTO users (`id`,`name`,`email`,`pwd`,`role`,`updated_at`) VALUES (null,'$name','$email','$password','1',NOW())";
            $result = mysqli_query($link,$sql_add_user);
            if($result && mysqli_affected_rows($link)==1){
                $_SESSION['name'] = $name; 
                $_SESSION['uid'] = mysqli_insert_id($link); 
                $_SESSION['uip'] = $_SERVER['REMOTE_ADDR'];
                msg_alert("success","you signed up successfully");
                header("location: index.php"); 
                die;
            }
        }
        


    }


 }
 else{
    msg_alert("alert","an error has occurred");;
 }
}
$token = tokens();
$_SESSION['token'] = $token;
?>

<?php
require_once "tpl/header.php";

?>
<div class="container text-center">
<div class="login-form">
    <form action="" method="post" name="signup">
        <h2 class="text-center">Sign up</h2>
        <div class="form-group">
            <span class="err"><?= $err_name ;?></span>
            <input type="text" class="form-control" placeholder="Name" required="required" name="name" value="<?=$old_vals->set_vals('name');?>">
        </div>   
        <div class="form-group">
        <span class="err"><?= $err_email ;?></span>
            <input type="text" class="form-control" placeholder="Email" required="required" name="email" value="<?=$old_vals->set_vals('email');?>">
        </div>
        <div class="form-group">
        <span class="err"><?= $err_pwd ;?></span>
            <input type="password" class="form-control" placeholder="Password" required="required" name="password">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="re enter Password" required="required" name="re_password">
        </div>
        <input type="hidden" name="token" value="<?= $token ;?>">
        <div class="form-group">
            <button name="signup" type="submit" class="btn btn-primary btn-large">Log in</button>
        </div>      
        <p class="text-center signup">have an account? <a href="login.php">Sign in</a></p>
    </form>

</div>
</div>


<?php
msg_stop();
require_once "tpl/footer.php";

?>