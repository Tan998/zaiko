<?php 
if (!defined('IN_SITE')) die ('The request not found');
 
// Thiết lập font chữ UTF8 để khỏi bị lõi font
header('Content-Type: text/html; charset=utf-8');
 
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_supper_admin()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
 
// Nếu người dùng submit delete user
if (is_submit('delete_add_item'))
{
    // Lấy ID và ép kiểu
    $id = input_post('id');
    if ($id)
    {
        // Lấy thông tin hanghoa
        $delete_nhapkho_ct = db_get_row(db_create_sql('SELECT * FROM nhapkho_ct {where}', array(
            'STT' => $id
        )));
            $sql2 = db_create_sql('DELETE FROM nhapkho_ct {where}', array(
                'STT' => $id
            ));
            if (db_execute($sql2)){
                ?>
                <script language="javascript">
                    if(alert('Deleted Successfuly!')){
                        window.location = '<?php redirect(base_url('admin')); ?>';
                    }
                </script>
                <?php
            }
            else{
                ?>
                <script language="javascript">
                    alert('Deleted Fail!');
                    window.location = '<?php redirect(base_url('admin')); ?>';
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

