<?php 
if (!defined('IN_SITE')) die ('The request not found');
 
// Thiết lập font chữ UTF8 để khỏi bị lõi font
header('Content-Type: text/html; charset=utf-8');
 
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_supper_admin()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
 
// Nếu người dùng submit delete user
if (is_submit('delete_qr'))
{
    // Lấy ID và ép kiểu
    $item_code = input_post('item_code');
    if ($item_code)
    {
        // Lấy thông tin hanghoa
        $item_hanghoa = db_get_row(db_create_sql('SELECT * FROM hanghoa {where}', array(
            'bin_code' => $item_code
        )));
            $sql = db_create_sql('DELETE FROM hanghoa {where}', array(
                'bin_code' => $item_code
            ));

        $item_hanghoa_ct = db_get_row(db_create_sql('SELECT * FROM hanghoa_ct {where}', array(
            'bin_code' => $item_code
        )));
            $sql2 = db_create_sql('DELETE FROM hanghoa_ct {where}', array(
                'bin_code' => $item_code
            ));

        $item_qr_tb = db_get_row(db_create_sql('SELECT * FROM qr_tb {where}', array(
            'bin_code' => $item_code
        )));
            $sql3 = db_create_sql('DELETE FROM qr_tb {where}', array(
                'bin_code' => $item_code
            ));
 
            if (db_execute($sql) && db_execute($sql2) && db_execute($sql3)){
                ?>
                <script language="javascript">
                    alert('Deleted Successfuly!');
                    window.location = '<?php echo input_post('redirect'); ?>';
                </script>
                <?php
            }
            else{
                ?>
                <script language="javascript">
                    alert('Deleted Fail!');
                    window.location = '<?php echo input_post('redirect'); ?>';
                </script>
                <?php
        }
    }
}
else{
    // Nếu không phải submit delete user thì chuyển về trang chủ
    redirect(base_url('admin'));
}

 ?>