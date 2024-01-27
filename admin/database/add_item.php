<?php if (!defined('IN_SITE')) die ('The request not found');
 
function db_user_get_by_username($username){
    $username = addslashes($username);
    $sql = "SELECT * FROM tb_user where username = '$username'";
    return db_get_row($sql);
}
function db_addItem_validate($data)
{
    // Biến chứa lỗi
    $error = array();
     
    if (!($error) && isset($data['SoPhieuN']) && $data['SoPhieuN']){
        $sql = "SELECT count(SoPhieuN) as counter FROM nhapkho WHERE SoPhieuN= '".addslashes($data['SoPhieuN'])."' ";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['SoPhieuN'] = 'abcdefghyklm。';
        }
    }
    if (isset($data['NgayNhap']) && $data['NgayNhap'] == ''){
            $error['NgayNhap'] = '入庫日を選択いてください';
    }

    return $error;
}


function db_addItem_ct_validate($data)
{
    // Biến chứa lỗi
    $error = array();

    /* VALIDATE CĂN BẢN */
    //
    if (isset($data['SoPhieuN']) && $data['SoPhieuN'] == ''){
        $error['SoPhieuN'] = 'no data';
    }
     
    //
    if (isset($data['MaHang']) && $data['MaHang'] == ''){
        $error['MaHang'] = 'no data';
    }
    if (isset($data['bin_code']) && $data['bin_code'] == ''){
        $error['bin_code'] = 'no data';
    }
    // Password
    if (isset($data['SLNhap']) && $data['SLNhap'] == ''){
        $error['SLNhap'] = '入庫数を入力してください。';
    }
    if (isset($data['SLNhap']) && $data['SLNhap'] < 1 || isset($data['SLNhap']) && $data['SLNhap'] > 999){
        $error['SLNhap'] = '1～999のみ可能、正しい入庫数を入力してください。';
    }
    if (isset($data['NguoiPhuTrach']) && $data['NguoiPhuTrach'] == ''){
        $error['NguoiPhuTrach'] = '取引先を入力してください。';
    }
     
    return $error;
}
?>