<?php
require_once "app/functions.php";
mysessionstart();
uNotConnected();

if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) &&ctype_digit($_GET['id'])){
$uid = $_SESSION['uid'];
$post_id = sql_cleaner(($_GET['id']));
$link = db_connect();
$sql_check_user_post = "SELECT uid FROM posts WHERE uid = $uid AND id = $post_id";
$result = mysqli_query($link,$sql_check_user_post);
if($result && mysqli_num_rows($result)==1){
    if(isset($_POST['del_post'])){
        if(isset($_POST['token']) && $_POST['token'] == $_SESSION['token']){
            $sql_del_post = "DELETE FROM posts WHERE id = $post_id";
            $result = mysqli_query($link,$sql_del_post);
            if($result && mysqli_affected_rows($link)==1){
                header("location:index.php");
                msg_alert("success","The post deleted successfully");
                die;
            }else{
                msg_alert("danger","unknown error");
            }
        }
    }
}
}else{
    header("location:index.php");
    msg_alert("danger","unknown error");
    die;
}
?>

<?php
$token = tokens();
$_SESSION['token'] = $token;
require_once "tpl/header.php";
msg_stop();

?>
<section id="intro">
<section class="maincontent">
<div class="container text-center">
<div class="row">
    <p class="text-alert">
        Are you sure you want to delete this post?
</p>
<form class="form w-50" action="" method="post" name="del_post">
<div class="group" role="group">
<input type="submit" class="btn btn-danger form-control" value="Delete" name="del_post">
</div>
<input type="hidden" name="token" value="<?= $token ;?>">
</form>
<a href="index.php">
<button class="btn btn-secondary form-control">Cancel</button>
</a>
 
</div>

</div>
</section>
</section>


<?php


require_once "tpl/footer.php";
?>
