<?php 
// Hàm thiết lập là đã đăng nhập
function set_logged($username, $level){
    session_set('ss_user_token', array(
        'username' => $username,
        'level' => $level
    ));
}

 // Hàm kiểm tra trạng thái người dùng đã đăng nhập chưa
function is_logged(){
    $user = session_get('ss_user_token');
    return $user;
}

// Hàm thiết lập đăng xuất
function set_logout(){
    session_delete('ss_user_token');
}

// Hàm thiết lập timeout
// gioi han trong 60p khong hoat dong se ket thuc phien dang nhap
function set_logged_timeout(){
    if (is_logged()) {
        $expiry = 3600;
        if (isset($_SESSION['LAST']) && (time() - $_SESSION['LAST'] > $expiry)) {
        session_unset();
        session_destroy();
        echo '<script language="javascript">alert("セッションの有効期限が切れました。\n もう一度ログインしてください。"); window.location.href = "'.create_link(base_url('admin'), array('m' => 'common', 'a' => 'login')).'";</script>';
        //redirect(base_url('admin'), array('m' => 'common', 'a' => 'login'));
        }
        else{$_SESSION['LAST'] = time();}
    }
}
 
// Hàm kiểm tra có phải là admin hay không
// 1 là admin
function is_admin(){
    $user  = is_logged();
    if (!empty($user['level']) && $user['level'] == '1'){
        return true;
    }
    return false;
}

// Hàm kiểm tra là supper admin
function is_supper_admin(){
    $user = is_logged();
    if (!empty($user['level']) && $user['level'] == '1' && $user['username'] == 'admin'){
        return true;
    }
    false;
}

// Lấy username người dùng hiện tại
function get_current_username(){
    $user  = is_logged();
    return isset($user['username']) ? $user['username'] : '';
}
 
// Lấy level người dùng hiện tại
function get_current_level(){
    $user  = is_logged();
    return isset($user['level']) ? $user['level'] : '';
}
 ?>