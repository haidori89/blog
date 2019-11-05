<?php
require_once "app/functions.php";
mysessionstart();
uNotConnected();
$err_title = "";
$err_category = "";
$err_file = "";
$err_post_body="";
?>

<?php
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) &&ctype_digit($_GET['id'])){
    $uid = $_SESSION['uid'];
    $post_id = sql_cleaner(($_GET['id']));
    $link = db_connect();
    $sql_check_user_post = "SELECT * FROM posts WHERE uid = $uid AND id = $post_id";
    $result = mysqli_query($link,$sql_check_user_post);
    if($result && mysqli_num_rows($result)==1){
     $old_data = mysqli_fetch_assoc($result);
    //form submit check
    if(isset($_POST['edit_post'])){

    if(isset($_POST['token']) && $_POST['token'] == $_SESSION['token']){

        if(empty($_POST['post_title'])){

            $err_title="Please enter a Title";

        }
        elseif(strlen($_POST['post_title'])>250){

            $err_title="Title must be maximum 250 chars";
            
        } 
        elseif(empty($_POST['post_cat'])){

            $err_category="Please enter a Category";

        }
        elseif(strlen($_POST['post_cat'])>50){

            $err_category="Category must be maximum 50 chars";
            
        }
        elseif(empty($_POST['post_body'])){

            $err_post_body = "please enter a post content";
        }
         else{
            $link = db_connect();
            define('UPLOAD_MAX_SIZE', 1024 * 1024 * 20);
            $img_ex = ['jpg', 'jpeg', 'png', 'gif', 'bpm'];

            $title = sql_cleaner(html_cleaner('post_title')) ;
            $category = sql_cleaner(html_cleaner('post_cat'));
            $post_content = sql_cleaner(html_cleaner('post_body'));
            $uid = $_SESSION['uid'];
            mysqli_set_charset($link,"utf8");
            if (!empty($_FILES['post_img']['name'])) {

                if (is_uploaded_file($_FILES['post_img']['tmp_name'])) {
    
                  if ($_FILES['post_img']['size'] <= UPLOAD_MAX_SIZE && $_FILES['post_img']['error'] == 0) {
    
                    $file_info = pathinfo($_FILES['post_img']['name']);
    
    
                    $file_ex = strtolower($file_info['extension']);
                    if (in_array($file_ex, $img_ex)) {
                        $file_name =$uid.time().$_FILES['post_img']['name'] ; 
                        $directory = "assets/img/posts/".$file_name;
                      move_uploaded_file($_FILES['post_img']['tmp_name'], $directory);
                      $post_img = $file_name;
                    }else{
                        $err_file = "Please choose an image file";
                    }
                  }else{
                    $err_file = "Image size is bigger then 20MB";
                  }
                }
              }else{
                $post_img = "default.jpg";
              }
              if(empty($err_file)){
              $sql_add_post ="UPDATE posts SET `title` ='$title',`category` = '$category',`post`='$post_content',`post_img`='$post_img' WHERE `id` = '$post_id' AND `uid` = '$uid'" ;
              $result = mysqli_query($link,$sql_add_post);
              if($result && mysqli_affected_rows($link)==1){
                  msg_alert("success","your post $title changed successfully");
                  header("location:index.php");
              }else{
                msg_alert("danger","Nothing changed, please try again");
              }
            }
            }

    }else{

        msg_alert("warning","faild to edit post");

    }
}else{
    msg_stop();
}
    }else{
        header("location:index.php");
        msg_alert("danger","unknown error");
    die;
    }

}  else{
    header("location:index.php");
    msg_alert("danger","unknown error");
die;

} 

?>

<?php
$token = tokens();
$_SESSION['token'] = $token;
require_once "tpl/header.php";
?>
<div class="intro">
<section id="maincontent">
<div class="container contact-form text-center">
            <div class="contact-image">
                <img src="https://image.ibb.co/kUagtU/rocket_contact.png" alt="rocket_contact"/>
            </div>
            <form action="" method="post" class="form" enctype="multipart/form-data">
                <h3>Edit your post</h3>
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <span class="err"><?= $err_title; ?></span>
                            <input type="text" name="post_title" class="form-control" placeholder="Title * Max 250 chars"  value="<?=$old_data['title'];?>" />
                        </div>
                        <div class="form-group">
                        <span class="err"><?= $err_category; ?></span>
                            <input type="text" name="post_cat" class="form-control" placeholder="Category * Max 50 chars" value="<?=$old_data['category'];?>" />
                        </div>
                        <div class="form-group">
                        <div class="custom-file">
                        <label class="custom-file-label" for="customFileLang">Upload photo</label><span> max 20MB</span>
                        <input type="file" class="form-control" name="post_img">
                        </div>
                        <span class="err"><?= $err_file; ?></span>
                    </div>
                    <div class="form-group">
                    <span class="err"><?= $err_post_body; ?></span>
                            <textarea name="post_body" class="form-control" placeholder="Post content *" style="width: 100%; height: 150px;" ><?=$old_data['post'];?></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="edit_post" class="btnContact" value="Save Post Changes" />
                        </div>
                        <input type="hidden" name="token" value="<?= $token ;?>"> 
                    </div>

                </div>
            </form>
            <div class="row">
            <div class="span10">
            <a href="index.php"><button class="btn btn-primary">Cancel</button> </a>
            </div>
            </div>
            </div>

      <!-- blank divider -->
      <div class="row">
        <div class="span12">
          <div class="blank10"></div>
        </div>
      </div>

  </section>
  </div>

<?php
msg_stop();
require_once "tpl/footer.php";
?>