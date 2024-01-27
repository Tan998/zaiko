<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
 
<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_admin()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
?>
 
<?php 
// Biến chứa lỗi
$error = array();
 
// Nếu người dùng submit form
if (is_submit('add_user'))
{   
    if (strlen(input_post('password')) <6 || strlen(input_post('password')) >16){
        $error['password'] = "パスワードは半角英数字6文字以上、16文字以内で入力してください。";
    }
    elseif (strlen(input_post('re_password')) <6 || strlen(input_post('re_password')) >16){
        $error['re_password'] = "パスワードは半角英数字6文字以上、16文字以内で入力してください。";
    }
    else{
        $password = input_post('password');
        $re_password = input_post('re_password');
            // Lấy danh sách dữ liệu từ form
        $data = array(
        'username'  => input_post('username'),
        'password'  => md5($password),
        're_password'  => md5($re_password),
        'email'     => input_post('email'),
        'fullname'  => input_post('fullname'),
        'level'     => input_post('level'),
        'add_date'  => date('Y/m/d H:i:s'),
        );
    // require file xử lý database cho user
    require_once('database/user.php');
     
    // Thực hiện validate
    $error = db_user_validate($data);
    }

    date_default_timezone_set('Asia/Tokyo');

     
    
    // Nếu validate không có lỗi
    if (!$error)
    {
        // Xóa key re_password ra khoi $data
        unset($data['re_password']);
         
        // Nếu insert thành công thì thông báo
        // và chuyển hướng về trang danh sách user
        if (db_insert('tb_user', $data)){
            ?>
            <script language="javascript">
                alert('ユーザーを追加完了しました。!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>';
            </script>
            <?php
            die();
        }
    }
}
?>
 
<?php include_once('widgets/header.php'); ?>
<style>
    
</style>
<h1>メンバーを追加</h1>
<div class="container">
    <div class="controls row">
        <div class="col-1 col-md-2"></div>
        <div class="col-10 col-md-8 shadow p-3 mb-5 bg-body rounded">
            <form id="main-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'user', 'a' => 'add')); ?>">
              <div class="mb-3">
                <label for="input-name" class="form-label">User Name</label>
                <input type="text" class="form-control" id="input-name" name="username" value="<?php echo input_post('username'); ?>" />
                <?php show_error($error, 'username'); ?>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input required type="password" class="form-control" id="exampleInputPassword1" name="password" value="<?php echo input_post('password'); ?>" />
                <div id="emailHelp" class="form-text">パスワードは半角英数字6文字以上、16文字以内で入力してください。</div>
                <?php show_error($error, 'password'); ?>
              </div>
                <div class="mb-3">
                <label for="exampleInputPassword2" class="form-label">Password2</label>
                <input required type="password" class="form-control" id="exampleInputPassword2" name="re_password" value="<?php echo input_post('re_password'); ?>" />
                <div id="emailHelp" class="form-text">パスワードは半角英数字6文字以上、16文字以内で入力してください。</div>
                <?php show_error($error, 're_password'); ?>
              </div>
                <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input required type="email" class="form-control" id="exampleInputEmail1" name="email" value="<?php echo input_post('email'); ?>" />
                <?php show_error($error, 'email'); ?>
              </div>
                <div class="mb-3">
                    <label for="input-fullname" class="form-label">Full Name</label>
                    <input required type="text" class="form-control" id="input-fullname" name="fullname" value="<?php echo input_post('fullname'); ?>">
                    <?php show_error($error, 'fullname'); ?>
                </div>
                <div class="mb-3">
                    <label for="form-select" class="form-label">Disabled select menu</label>
                    <select id="form-select" class="form-select" name="level">
                        <option value="">-- レベルを選択 --</option>
                        <option value="1" <?php echo (input_post('level') == 1) ? 'selected' : ''; ?>>Admin</option>
                        <option value="2" <?php echo (input_post('level') == 2) ? 'selected' : ''; ?>>Member</option>
                    </select>
                    <?php show_error($error, 'level'); ?>
                </div>
              <a class="btn btn-success" onclick="$('#main-form').submit()" href="#">Save</a>
              <input type="hidden" name="request_name" value="add_user"/>
              <a class="btn btn-secondary" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>">戻る</a>
            </form>
        </div>
        <div class="col-md-2 col-1"></div>
    </div>
</div>


 
<?php include_once('widgets/footer.php'); ?>