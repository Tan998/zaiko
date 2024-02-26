<?php if (!defined('IN_SITE')) die ('The request not found');
 

// Hàm validate dữ liệu bảng hanghoa_ct
function db_item_validate($data)
{
    // Biến chứa lỗi
    $error = array();
     
    /* VALIDATE CĂN BẢN */
    // Itemname
    if (isset($data['TenHang']) && $data['TenHang'] == ''){
        $error['itemname'] = '商品名を入力してください。';
    }
     
    // bin_code
    if (isset($data['bin_code']) && $data['bin_code'] == ''){
        $error['bin_code'] = 'QRコードの値を入力してください。';
    }
    // 保管場所
    if (isset($data['hokanbasho']) && $data['hokanbasho'] == ''){
        $error['hokanbasho'] = '保管場所を入力してください。';
    }
    // 保管場所
    if (isset($data['joutai']) && $data['joutai'] == ''){
        $error['joutai'] = '商品の状態を入力してください。';
    }
     
    /* VALIDATE LIÊN QUAN CSDL */
    // Chúng ta nên kiểm tra các thao tác trước có bị lỗi không, nếu không bị lỗi thì mới
    // tiếp tục kiểm tra bằng truy vấn CSDL
    // Username
    if (!($error) && isset($data['itemname']) && $data['itemname']){
        $sql = "SELECT count(id) as counter FROM hanghoa WHERE TenHang='".addslashes($data['itemname'])."'";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['itemname'] = 'この商品はすでに存在します。';
        }
    }
     
    // bin_code
    if (!($error) && isset($data['bin_code']) && $data['bin_code']){
        $sql = "SELECT count(id) as counter FROM hanghoa_ct WHERE bin_code='".addslashes($data['bin_code'])."'";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['bin_code'] = 'このQRコードはすでに存在します。';
        }
    }
    // MaHang
    if (!($error) && isset($data['bin_code']) && $data['bin_code']){
        $sql = "SELECT count(id) as counter FROM hanghoa WHERE MaHang='".addslashes($data['bin_code'])."'";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['bin_code'] = 'このQRコードはすでに存在します。tan';
        }
    }
    return $error;
}

function db_edit_item_validate($data)
{
    // Biến chứa lỗi
    $error = array();
     
    /* VALIDATE CĂN BẢN */
    // Itemname
    if (isset($data['TenHang']) && $data['TenHang'] == ''){
        $error['itemname'] = '商品名を入力してください。';
    }
     
    // bin_code
    if (isset($data['bin_code']) && $data['bin_code'] == ''){
        $error['bin_code'] = 'QRコードの値を入力してください。';
    }
    // 保管場所
    if (isset($data['hokanbasho']) && $data['hokanbasho'] == ''){
        $error['hokanbasho'] = '保管場所を入力してください。';
    }
    // 保管場所
    if (isset($data['joutai']) && $data['joutai'] == ''){
        $error['joutai'] = '商品の状態を入力してください。';
    }

    if (!($error) && isset($data['bin_code']) && $data['bin_code']){
        $sql = "SELECT count(id) as counter FROM hanghoa_ct WHERE bin_code='".addslashes($data['bin_code'])."'";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['bin_code'] = $data['bin_code'].'コードはすでに存在します。';
        }
    }
    // MaHang
    if (!($error) && isset($data['bin_code']) && $data['bin_code']){
        $sql = "SELECT count(id) as counter, bin_code FROM hanghoa WHERE MaHang='".addslashes($data['bin_code'])."'";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['bin_code'] = 'このQRコードはすでに存在します。';

        }
    }
    return $error;
}
function db_edit_item_validate_coban($data)
{
    // Biến chứa lỗi
    $error = array();
     
    /* VALIDATE CĂN BẢN */
    // Itemname
    if (isset($data['TenHang']) && $data['TenHang'] == ''){
        $error['itemname'] = '商品名を入力してください。';
    }
     
    // bin_code
    if (isset($data['bin_code']) && $data['bin_code'] == ''){
        $error['bin_code'] = 'QRコードの値を入力してください。';
    }
    // 保管場所
    if (isset($data['hokanbasho']) && $data['hokanbasho'] == ''){
        $error['hokanbasho'] = '保管場所を入力してください。';
    }
    // 保管場所
    if (isset($data['joutai']) && $data['joutai'] == ''){
        $error['joutai'] = '商品の状態を入力してください。';
    }
    return $error;
}
?>