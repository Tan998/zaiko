<?php if (!defined('IN_SITE')) die('The request not found'); ?>
 
<!DOCTYPE html>
<html lang="jp">
<head>
    <title>在庫管理</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <!-- Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!--icon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-1.9.0.js"></script>
    <style>
      body{
        font-family: 'Noto Sans JP', sans-serif;
        background-color: antiquewhite;
        min-width: 300px;
        min-height: 575px;
      }
      a{
        text-decoration: none;
      }
      li {
        list-style: none;
      }
    </style>
</head>
<body >

<!-- check timeout-->
<?php set_logged_timeout(); ?>
<!-- Navbar-->
        <?php if (is_logged()){ ?>
        <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
          <div class="container-fluid">
            <?php if (is_admin()){ ?>
            <a class="navbar-brand" href="<?php echo create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard')); ?>">Admin</a>
            <?php } ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard')); ?>">Home</a>
                </li>
                <?php if (is_admin()){ ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>">ユーザー管理</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo create_link(base_url('admin'), array('m' => 'action_qr_mana', 'a' => 'qrcode_manager')); ?>">コード管理</a>
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