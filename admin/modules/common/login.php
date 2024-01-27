<?php 
$error = array();
 
// BƯỚC 1: KIỂM TRA NẾU LÀ ADMIN THÌ REDIRECT
if (is_admin()){
    redirect(base_url('admin/?m=common&a=dashboard'));
}
 
// BƯỚC 2: NẾU NGƯỜI DÙNG SUBMIT FORM
if (is_submit('login'))
{    
    // lấy tên đăng nhập và mật khẩu
    $username = input_post('username');
    $password = input_post('password');
     
    // Kiểm tra tên đăng nhập
    if (empty($username)){
        $error['username'] = 'ユーザー名を入力してください。';
    }
     
    // Kiểm tra mật khẩu
    elseif (empty($password)){
        $error['password'] = 'パスワードを入力してください。';
    }
    elseif (strlen($password) <6 || strlen($password) >16){
        $error['password'] = "パスワードは半角英数字6文字以上、16文字以内で入力してください。";
    }
    // Nếu không có lỗi
    if (!$error)
    {
        // include file xử lý database user
        include_once('database/user.php');
         
        // lấy thông tin user theo username
        $user = db_user_get_by_username($username);
         
        // Nếu không có kết quả
        if (empty($user)){
            $error['username'] = 'ユーザー名は間違いました。';
        }
        // nếu có kết quả nhưng sai mật khẩu
        else if ($user['password'] != md5($password)){
            $error['password'] = 'パスワードは間違いました。';
        }
         
        // nếu mọi thứ ok thì tức là đăng nhập thành công 
        // nên thực hiện redirect sang trang chủ
        if (!$error){
            set_logged($user['username'], $user['level']);
            update_session_id();
            redirect(base_url('admin/?m=common&a=dashboard'));
        }
    }
}

function update_session_id(){
        $user = session_get('ss_user_token');
        $sql = db_create_sql("SELECT * FROM tb_user {where}", array('username' => $user['username'] ));
        $row = db_get_row($sql); // lấy row['id'] từ db

        session_regenerate_id();
        $user_session_id = session_id();
        $query = db_create_sql("UPDATE tb_user SET user_session_id = '".$user_session_id."' {where}", array('id' => $row['id'] ));
        db_execute($query);
        $_SESSION['id'] = $row['id'];
        $_SESSION['user_session_id'] = $user_session_id;
        echo $user['username']."<br>";
        echo $user_session_id;
}

?>

<?php include_once('widgets/header.php'); ?>
<style>
    body {
        background-color: antiquewhite;
    }
</style>
<!-- Section: Design Block -->
<section class="">
  <!-- Jumbotron -->
  <div class="px-4 py-5 px-md-5 text-center text-lg-start">
    <div class="container">
      <div class="row gx-lg-5 d-flex justify-content-center">
        <div class="col-lg-6 mb-5 mb-lg-0">

        <div class="col-lg-12 mb-5 mb-lg-0">
          <div class="card">
            <div class="card-header"><h1>ログイン</h1></div>
            <div class="card-body py-5 px-md-5">
              <form method="post" action="<?php echo base_url('admin/?m=common&a=login'); ?>">
                <!-- username input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form3Example3">Username</label>
                  <input type="text" name="username" value="" id="form3Example3" class="form-control" required placeholder="Username"/>
                  <?php show_error($error, 'username'); ?>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form3Example4">Password</label>
                  <input type="password" name="password" value="" id="form3Example4" class="form-control" required placeholder="Password" />
                  <?php show_error($error, 'password'); ?>
                </div>
                <!-- Submit button -->
                <input class="btn btn-primary btn-block mb-4" type="submit" name="login-btn" value="ログイン" />
                <input type="hidden" name="request_name" value="login"/>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->
<?php include_once('widgets/footer.php'); ?>