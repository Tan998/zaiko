<?php 
error_reporting(0);
check_login_dumlicate();

function check_login_dumlicate() {
    $query = "
    SELECT user_session_id FROM tb_user 
    WHERE id = '".$_SESSION['id']."'
";
    $row = db_get_row($query); // lấy row['user_session_id'] từ db

    if($_SESSION['user_session_id'] != $row['user_session_id'])
    {
        $data['output'] = 'logout';
        //echo '<script language="javascript">alert("30分以上サイトと操作しなかった。\nログインしてください。"); window.location.href = "'.create_link(base_url('admin'), array('m' => 'common', 'a' => 'logout')).'";</script>';
    }
    else
    {
        $data['output'] = 'logged';
    }
    echo json_encode($data);
}

 ?>