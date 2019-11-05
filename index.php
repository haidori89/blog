<?php
require_once "app/functions.php";
mysessionstart();
uNotConnected();
?>

<?php
require_once "tpl/header.php";
msg_stop();
?>

<?php
$link = db_connect();
$sql_get_posts = "SELECT posts.*,users.name FROM posts LEFT JOIN users on users.id = posts.uid";
$result = mysqli_query($link, $sql_get_posts);
if ($result && mysqli_num_rows($result) > 0)
{
    $posts_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
else
{
    msg_alert("warning", "unknown error, try to refresh the page");
}

?>


<section id="intro">
  <div class="container">
    <div class="row">
      <div class="span6">
        <h2><strong><span class="highlight primary"><?=$_SESSION['name'] ?></span></strong></h2>
        <p class="lead">
          Welcome <?=$_SESSION['name'] ?> to dori mobile blog.
        </p>
        <ul class="list list-ok strong bigger">
          <li>Professional articles about mobile world</li>
          <li>whats new about world of mobile</li>
          <li>comparing all brands</li>
        </ul>
        <a href="add_post.php"><button class="btn btn-primary">+ Add New Post</button></a>
      </div>
      <div class="span6">
        <div class="group section-wrap upper" id="upper">
          <div class="section-2 group">
            <ul id="images" class="rs-slider">
              <li class="group">
                <a href="#">
                  <img src="assets/img/slides/refine/slide1.png" alt="" width="50%" />
                </a>
              </li>
              <li class="group">
                <a href="#" class="slide-parent">
                  <img src="assets/img/slides/refine/slide2.png" alt="" />
                </a>
              </li>
              <li class="group">
                <img src="assets/img/slides/refine/slide3.png" alt="" />
              </li>
            </ul>
          </div>
          <!-- /.section-2 -->
        </div>

      </div>
    </div>
  </div>

</section>
<section id="maincontent">
  <div class="container">
    <div class="row">
      <?php if (isset($posts_data)): ?>
        <?php foreach ($posts_data as $data): ?>
          <div class="span4">
            <div class="features">
              <div class="category"><?=htmlspecialchars($data['category']); ?></div>
              <img src="assets/img/posts/<?=$data['post_img']; ?>" class="post_sm_img" />
              <span class="date"><?=$data['create_time']; ?></span>
              <div class="features_content">
                <h3><?=htmlspecialchars($data['title']); ?></h3>
                <p class="left postConSm">
                  <h6><?=htmlspecialchars($data['name']); ?> </h6>
                  <?=substr(htmlspecialchars($data['post']) , 0, 100); ?>...
                </p>
                <a href="article.php?id=<?=$data['id'] ?>" class="btn btn-color btn-rounded"><i class="icon-angle-right"></i> Read more</a>
                <?php if ($_SESSION['uid'] == $data['uid']): ?>
                  <a href="delete_post.php?id=<?=$data['id'] ?>"><button class="btn btn-danger">Delete</button></a>
                  <a href="edit_post.php?id=<?=$data['id'] ?>"><button class="btn btn-info">Edit</button></a>
                <?php
        endif ?>
              </div>
            </div>
          </div>
        <?php
    endforeach; ?>
      <?php
endif; ?>
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

<?php

require_once "tpl/footer.php";
?>
