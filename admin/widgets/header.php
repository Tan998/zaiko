<?php if (!defined('IN_SITE')) die('The request not found'); ?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Homebear在庫管理</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Language" content="ja">
     <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">

    <!-- Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.9.0.js"></script>
        <!--icon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    
    <!--
    <div id="google_translate_element" style="right:0">
         <script>
              function googleTranslateElementInit() {
                   new google.translate.TranslateElement({
                        pageLanguage: 'ja',
                        includedLanguages: 'zh-CN,zh-TW,en,ja,vi'
                   }, 'google_translate_element');
              }
              //uk,ca,af,sq,ar,be,bg,hr,cs,da,nl,,et,tl,fi,fr,gl,de,el,ht,iw,hi,hu,is,id,ga,it,ko,lv,lt,mk,ms,mt,no,fa,pl,pt,ro,ru,sr,sk,sl,es,sw,sv,th,tr,,cy,yi
         </script>
         <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    </div>-->
    <style>

      body{
        /*color: #73879C;*/
        font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
        font-size: 15px;
        font-weight: 400;
        line-height: 1.471;
        background-color: antiquewhite;
        min-width: 310px;
        min-height: 575px;
      }
      html {
          /* THIS IS SMOOTH */
          scroll-behavior: smooth;
        }
        #scroll_navheader {
            position: fixed;
            bottom: 40px;
            right: 5px;
        }
      a{
        color: #313131;
        text-decoration: none;
      }
      li {
        list-style: none;
        overflow: hidden;
      }
      label {
        font-style: oblique;
      }
      h1 {
          padding: 0.5em;/*文字周りの余白*/
          color: #494949;/*文字色*/
          background: #fffaf4;/*背景色*/
          backdrop-filter: blur(30px);
          /*border-left: solid 5px #ffaf58;/*左線（実線 太さ 色）*/
          /*border-right: solid 5px #ffaf58;/*右線（実線 太さ 色）*/
          text-align: center;
          margin-top:20px;

        }
        .navbar-brand:hover {
            /*box-shadow:  0 0 1px #fff, 0 0 50px #fff, 0 0 2px #F39800, 0 0 3px #F39800, 0 0 5px #F39800, 0 0 5px #F39800, 0 1px 3px #F39800;*/
        }
        .navbar-nav li:hover {
            box-shadow:  0 0 1px #fff, 0 0 50px #fff, 0 0 2px #F39800, 0 0 3px #F39800, 0 0 5px #F39800, 0 0 5px #F39800, 0 1px 3px #F39800;
        }
        .item_name {
                display: block;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;   
            }
        .item_name:hover{
                white-space: wrap;
                overflow: visible;
            }
        .rounded-9 {
            border-radius: .9rem!important;
        }

    </style>
</head>
<body >

<!-- check timeout-->
<?php set_logged_timeout(); ?>
<!-- Navbar-->
        <?php if (is_logged()){ ?>
        <nav id="nav_header" class="navbar navbar-expand-lg navbar-light shadow-sm mb-2">
          <div class="container-fluid">
            <a class="navbar-brand p-0 position-absolute top-0 start-50 translate-middle-x" href="<?php echo create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard')); ?>">
                <!--<h6 class="homebear" style="
                font-family: 'Black Ops One', system-ui;
                color: #fff;
                text-shadow: 0 0 1px #fff, 0 0 50px #fff, 0 0 2px #F39800, 0 0 3px #F39800, 0 0 5px #F39800, 0 0 5px #F39800, 0 1px 3px #F39800;">homebear</h6>-->
                <img class="hb-logo" src="img/hb-logo1.svg" alt="homebear logo" height="58px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard')); ?>"><strong><i class="bi bi-house"></i> Home</strong></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo create_link(base_url('admin'), array('m' => 'add_item', 'a' => 'add_item')); ?>"><i class="bi bi-download"></i> 入庫</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo create_link(base_url('admin'), array('m' => 'remove_item', 'a' => 'remove_item')); ?>"><i class="bi bi-upload"></i> 出庫</a>
                </li>
                <?php if (is_admin()){ ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo create_link(base_url('admin'), array('m' => 'action_qr_mana', 'a' => 'qrcode_manager')); ?>"><i class="bi bi-qr-code"></i> コード管理</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>"><i class="bi bi-person-gear"></i> ユーザー管理</a>
                </li>
                <?php } ?>
              </ul>
            
            </div>
          </div>
        </nav>
        
        <?php } ?>
<div id="page">
<?php 
if(is_logged()){check_login_dumlicate();}

function check_login_dumlicate() {
    $query = "
    SELECT user_session_id FROM tb_user 
    WHERE id = '".$_SESSION['id']."'
";
    $row = db_get_row($query); // lấy row['user_session_id'] từ db

    if($_SESSION['user_session_id'] != $row['user_session_id'])
    {
        //$data['output'] = 'logout';
        echo '<script language="javascript">alert("別のデバイスからログインしています。ログインセッションが終わり。"); window.location.href = "'.create_link(base_url('admin'), array('m' => 'common', 'a' => 'logout')).'";</script>';
    }
}

 ?>
</div>
<script>
/*
function check_session_id()
{
    var session_id = "<?php echo $_SESSION['user_session_id']; ?>";
    var url = "<?php echo create_link(base_url('admin'), array('m' => 'common', 'a' => 'check_login')); ?>";
    fetch(url).then(function(response){

        return response.json();

    }).then(function(responseData){
        console.log(responseData.output);
        if(responseData.output == 'logout')
        {
            window.location.href = "<?php echo create_link(base_url('admin'), array('m' => 'common', 'a' => 'logout')); ?>";
        }

    });
}

setInterval(function(){

    check_session_id();
    
}, 10000);
*/
</script>