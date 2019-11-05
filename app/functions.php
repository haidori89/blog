<?php
//database login function
if ( ! function_exists('db_connect') ) {

  function db_connect() {

    if ( ! $link = @mysqli_connect("localhost", "root", "", "mobile_blog")) {

      die('Error connecting to mysql server!');
      
    }

    return $link;
    
  }

}

//csrf tokens function
if ( ! function_exists('tokens') ) {

    function tokens() {
  
    $token = sha1(time(). md5(strtotime("now")));
  
      return $token;
      
    }
  
  }


//session start function
  if( !function_exists("mysessionstart")){
    function mysessionstart(){
      session_start();
      session_regenerate_id();
      
    }
  }

  //check if user is not connected (need to be aplied on connected user pages)

  if( !function_exists("uNotConnected")){
    function uNotConnected(){
      if(empty($_SESSION['uid'])){
       header("location: login.php");
      }
    }
  }

  //check if user connected (need to be aplied on unconnected user pages)
  if( !function_exists("uConnected")){
    function uConnected(){
      if(!empty($_SESSION['uid'])){
       header("location: index.php"); 
      }
    }
  }
  //check if user session ip is the same as current user ip
  if( !function_exists("userip")){
    function userip(){
      if(!empty($_SESSION['uip'])){
        if($_SESSION['uip'] != $_SERVER['REMOTE_ADDR']){
        session_destroy();
        header("location: login.php");
        }
      }
    }
  }

//alert masseges start
  if( !function_exists("msg_alert")){
    function msg_alert($msg_type,$msg_content){
      if(empty($_SESSION['msg'])){
        $_SESSION['msg']  = $msg_content;  
        $_SESSION['msg_type']  = $msg_type; 
     }
    }
  }


//alert massege stop
  if( !function_exists("msg_stop")){
    function msg_stop(){
      if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])){
        $_SESSION['msg'] ="";
        $_SESSION['msg_type']="";
        unset($_SESSION['msg']);  
        unset($_SESSION['msg_type']);
     }
    }
  }

  //sql injection cleaner vals
  if( !function_exists("sql_cleaner")){
    function sql_cleaner($sql_var){
        $sql_var = mysqli_real_escape_string(db_connect(),trim($sql_var));
        return $sql_var;
    }
  }

   //html cleaner vals
   if( !function_exists("html_cleaner")){
    function html_cleaner($html_var){
        $html_var = trim(filter_input(INPUT_POST, $html_var,FILTER_SANITIZE_STRING));
        return $html_var;
    }
  }

?>