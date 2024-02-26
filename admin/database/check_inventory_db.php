<?php if (!defined('IN_SITE')) die ('The request not found');
 

function db_check_inventory_validate($data)
{
    // Biến chứa lỗi
    $error = array();

    /* VALIDATE CĂN BẢN */
    //
    if (isset($data['bin_code']) && $data['bin_code'] == ''){
        $error['bin_code'] = 'no data';
    }
    //
    if (isset($data['SL_truoccheck']) && $data['SL_truoccheck'] == ''){
        $error['fix_before_number'] = '現在在庫数の値がない。';
    }
    if (isset($data['SL_saucheck']) && $data['SL_saucheck'] == ''){
        $error['fix_after_number'] = '棚卸の値がない。';
    }
    if (isset($data['note']) && $data['note'] == ''){
        $error['note'] = 'メモが必要ですからご入力してください。';
    }
    if (isset($data['SL_truoccheck']) && $data['SL_truoccheck'] < 0){
        $error['fix_before_number'] = '棚卸の値は0～のみ可能、正しい入庫数を入力してください。';
    }
    if (isset($data['SL_saucheck']) && $data['SL_saucheck'] < 1 || isset($data['SL_saucheck']) && $data['SL_saucheck'] > 9999){
        $error['fix_after_number'] = '棚卸の値は1～9999のみ可能、正しい入庫数を入力してください。';
    }
     
    return $error;
}
?>