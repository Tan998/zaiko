<?php if (!defined('IN_SITE')) die ('The request not found');
 
function db_user_get_by_username($username){
    $username = addslashes($username);
    $sql = "SELECT * FROM tb_user where username = '$username'";
    return db_get_row($sql);
}
// Hàm validate dữ liệu bảng User
function db_user_validate($data)
{
    // Biến chứa lỗi
    $error = array();
     
    /* VALIDATE CĂN BẢN */
    // Username
    if (isset($data['username']) && $data['username'] == ''){
        $error['username'] = 'ユーザー名を入力してください。';
    }
     
    // Email
    if (isset($data['email']) && $data['email'] == ''){
        $error['email'] = 'メールアドレスを入力してください。';
    }
    if (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false){
        $error['email'] = '無効なメールアドレス';
    }
     
    // Password
    if (isset($data['password']) && $data['password'] == ''){
        $error['password'] = 'パスワードを入力してください。';
    }
    // Re_password
    if (isset($data['password']) && isset($data['re_password']) && $data['password'] != $data['re_password']){
        $error['re_password'] = 'パスワードを再入力してください。';
    }

    // Level
    if (isset($data['level']) && !in_array($data['level'], array('1', '2'))){
        $error['level'] = '選択したレベルがありません。';
    }
     
    /* VALIDATE LIÊN QUAN CSDL */
    // Chúng ta nên kiểm tra các thao tác trước có bị lỗi không, nếu không bị lỗi thì mới
    // tiếp tục kiểm tra bằng truy vấn CSDL
    // Username
    if (!($error) && isset($data['username']) && $data['username']){
        $sql = "SELECT count(id) as counter FROM tb_user WHERE username='".addslashes($data['username'])."' COLLATE SQL_Latin1_General_CP1_CS_AS";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['username'] = 'このユーザー名はすでに存在します。';
        }
    }
     
    // Email
    if (!($error) && isset($data['email']) && $data['email']){
        $sql = "SELECT count(id) as counter FROM tb_user WHERE email='".addslashes($data['email'])."' COLLATE SQL_Latin1_General_CP1_CS_AS";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['email'] = 'このメールアドレスはすでに存在します。';
        }
    }
     
    return $error;
}
?>