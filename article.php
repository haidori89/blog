<?php
require_once "app/functions.php";
mysessionstart();
uNotConnected();

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) && ctype_digit($_GET['id']))
{
    $uid = $_SESSION['uid'];
    $post_id = sql_cleaner(($_GET['id']));
    $link = db_connect();
    $sql_get_post = "SELECT posts.*,users.name FROM posts LEFT JOIN users on users.id = posts.uid WHERE posts.id = $post_id
    ";
    $result = mysqli_query($link, $sql_get_post);
    if ($result && mysqli_num_rows($result) == 1)
    {
        $post_data = mysqli_fetch_assoc($result);
    }
    else
    {
        header("location:index.php");
        msg_alert("danger", "unknown error1");
        die;
    }
}
else
{
    header("location:index.php");
    msg_alert("danger", "unknown error");
    die;
}
?>

<?php
require_once "tpl/header.php";

?>
<section id="intro">
  <div class="container">
    <div class="row">

      <div class="span8">
        <!-- start article  -->
        <article class="blog-post">
          <div class="post-heading">
            <h3><?=htmlspecialchars($post_data['title']); ?></h3>
          </div>
          <div class="row">
            <div class="span3">
              <div class="post-icon">
              <img src="assets/img/posts/<?=$post_data['post_img']; ?>" class="post_bg_img" />
              </div>
              <ul class="post-meta">
                <li class="first"><i class="icon-user"></i><span><?=htmlspecialchars($post_data['name']); ?></span></li>
                <li class="first"><i class="icon-calendar"></i><span><?=substr($post_data['create_time'],0,10); ?></span></li>
                <li><i class="icon-list-alt"></i><span><?=htmlspecialchars($post_data['category']); ?></span></li>
              </ul>
              <div class="clear"></div>
            </div>
            <div class="span5">
              <p>
              <?=htmlspecialchars($post_data['post']); ?>
              </p>
            </div>
          </div>
            <?php if($uid == $post_data['uid']):?>
            <a href="edit_post.php?id=<?=$post_id ?>"><button class="btn btn-info">Edit</button></a>
            <a href="delete_post.php?id=<?=$post_id ?>"><button class="btn btn-danger">Delete</button></a>
            <?php endif;?>
        </article>
      </div>
    </div>
</section>


<?php
require_once "tpl/footer.php";

?>
