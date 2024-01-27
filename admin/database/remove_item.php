<?php if (!defined('IN_SITE')) die ('The request not found');
 
function db_user_get_by_username($username){
    $username = addslashes($username);
    $sql = "SELECT * FROM tb_user where username = '$username'";
    return db_get_row($sql);
}
function db_removeItem_validate($data)
{
    // Biến chứa lỗi
    $error = array();
     
    if (!($error) && isset($data['SoPhieuX']) && $data['SoPhieuX']){
        $sql = "SELECT count(SoPhieuX) as counter FROM xuatkho WHERE SoPhieuX= '".addslashes($data['SoPhieuX'])."' ";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['SoPhieuX'] = 'abcdefghyklm。';
        }
    }
    if (isset($data['NgayXuat']) && $data['NgayXuat'] == ''){
            $error['NgayXuat'] = '出庫日を選択いてください';
    }

    return $error;
}


function db_removeItem_ct_validate($data)
{
    // Biến chứa lỗi
    $error = array();

    /* VALIDATE CĂN BẢN */
    //
    if (isset($data['SoPhieuX']) && $data['SoPhieuX'] == ''){
        $error['SoPhieuX'] = 'no data';
    }
     
    //
    if (isset($data['MaHang']) && $data['MaHang'] == ''){
        $error['MaHang'] = 'no data';
    }
    if (isset($data['bin_code']) && $data['bin_code'] == ''){
        $error['bin_code'] = 'no data';
    }
    // Password
    if (isset($data['SLXuat']) && $data['SLXuat'] == ''){
        $error['SLXuat'] = '出庫数を入力してください。';
    }
    if (isset($data['SLXuat']) && $data['SLXuat'] < 1 || isset($data['SLXuat']) && $data['SLXuat'] > 999){
        $error['SLXuat'] = '1～999のみ可能、正しい入庫数を入力してください。';
    }
    if (isset($data['NguoiPhuTrach']) && $data['NguoiPhuTrach'] == ''){
        $error['NguoiPhuTrach'] = '取引先を入力してください。';
    }
     
    return $error;
}
?>