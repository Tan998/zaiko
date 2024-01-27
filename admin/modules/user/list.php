<?php if (!defined('IN_SITE')) die ('The request not found');

    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
    ?>
 
    <?php include_once('widgets/header.php'); ?>
 
    <?php 
    // VỊ TRÍ 01: CODE XỬ LÝ PHÂN TRANG 
    // Tìm tổng số records
    $sql = db_create_sql('SELECT count(id) as counter from tb_user {where}');
    $result = db_get_row($sql);
    $total_records = $result['counter'];
 
    // Lấy trang hiện tại
    $current_page = input_get('page');
 
    // Lấy limit
    $limit = 10;
 
    // Lấy link
    $link = create_link(base_url('admin'), array(
        'm' => 'user',
        'a' => 'list',
        'page' => '{page}'
    ));
 
    // Thực hiện phân trang
    $paging = paging($link, $total_records, $current_page, $limit);
 
    // Lấy danh sách User
    //$sql = db_create_sql("SELECT * FROM tb_user {where} LIMIT {$paging['start']}, {$paging['limit']}");
    $sql = db_create_sql("SELECT * FROM tb_user");
    $users = db_get_list($sql);
?>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<style>
    .form-delete a {
        font-size: 12px;
    }
    body{
        font-family: 'Noto Sans JP', sans-serif;
        background-color: antiquewhite;
        min-width: 310px;
        min-height: 575px;
      }
</style>
    <div class="container-fluid">
            <h1>メンバー一覧</h1>

            <div class="col-sm-12">    
                <div class="controls">
                    <a class="btn btn-secondary" href="<?php echo create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard')); ?>">戻る</a>
                    <a class="btn btn-success" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'add')); ?>">追加</a>
                </div>

                <table class="table table-striped table-hover table-bordered" id="my_table">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">ユーザー名</th>
                            <th scope="col">メール</th>
                            <th scope="col">レベル</th>
                            <th scope="col">作成日</th>
                            <?php if (is_supper_admin()){ ?>
                            <th scope="col"></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php // VỊ TRÍ 02: CODE HIỂN THỊ NGƯỜI DÙNG ?>
                        <?php foreach ($users as $item){ ?>
                        <tr class="text-center">
                            <td><?php echo $item['username']; ?></td>
                            <td><?php echo $item['email']; ?></td>
                            <td><?php if($item['level'] == 2){echo "Member";} elseif($item['level'] == 1) {echo "Admin";} ?></td>
                            <td><?php echo $item['add_date']; ?></td>
                            <?php if (is_supper_admin()){ ?>
                            <td>
                                <form method="POST" class="form-delete" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'user', 'a' => 'delete')); ?>">
                                    <a hidden class="btn btn-success" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'edit', 'id' => $item['id'])); ?>">Edit</a>
                                    <input type="hidden" name="user_id" value="<?php echo $item['id']; ?>"/>
                                    <input type="hidden" name="request_name" value="delete_user"/>
                                    <a href="#" class="btn-submit btn btn-danger"><i class="bi bi-trash"></i>Delete</a>
                                </form>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                 
                <div class="pagination">
                    <?php 
                    // VỊ TRÍ 03: CODE HIỂN THỊ CÁC NÚT PHÂN TRANG
                    //echo $paging['html']; 
                    ?>
                </div>
        </div>
    </div>

    <script>new DataTable('#my_table');</script>
    
            <script language="javascript">
                $(document).ready(function(){
                    // Nếu người dùng click vào nút delete
                    // Thì submit form
                    $('.btn-submit').click(function(){
                        $(this).parent().submit();
                        return false;
                    });
             
                    // Nếu sự kiện submit form xảy ra thì hỏi người dùng có chắc không?
                    $('.form-delete').submit(function(){
                        if (!confirm('Comfirm to delete?')){
                            return false;
                        }
                         
                        // Nếu người dùng chắc chắn muốn xóa thì ta thêm vào trong form delete
                        // một input hidden có giá trị là URL hiện tại, mục đích là giúp ở 
                        // trang delete sẽ lấy url này để chuyển hướng trở lại sau khi xóa xong
                        $(this).append('<input type="hidden" name="redirect" value="'+window.location.href+'"/>');
                         
                        // Thực hiện xóa
                        return true;
                    });
                });
            </script>
<?php include_once('widgets/footer.php'); ?>