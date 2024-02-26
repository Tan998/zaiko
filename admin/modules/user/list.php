<?php if (!defined('IN_SITE')) die ('The request not found');

    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        header('Location: ' . create_link(base_url('admin'), array('m' => 'common', 'a' => 'logout')));
        exit;
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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.4.1/css/rowGroup.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/rowgroup/1.4.1/js/dataTables.rowGroup.min.js"></script>

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
      div.dataTables_wrapper div.dt-row {
        overflow-x: auto;
      }
</style>
<h1>メンバー一覧</h1>
    <nav class="mt-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'dashboard')); ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">ユーザー管理</li>
      </ol>
    </nav>
    <div class="container-fluid mb-5 bg-light">
            <div class="col-sm-12">    
                <div class="controls mb-2">
                    <a class="btn btn-success" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'add')); ?>">アカウントの新規登録</a>
                </div>

                <table class="table table-light table-striped table-hover table-bordered" id="my_table">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">ユーザー名</th>
                            <th scope="col">メール</th>
                            <th scope="col">レベル</th>
                            <th scope="col">氏名</th>
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
                            <td><?php echo $item['fullname']; ?></td>
                            <td><?php echo $item['add_date']; ?></td>
                            <?php if (is_supper_admin()){ ?>
                            <td>
                                <form method="POST" class="form-delete" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'user', 'a' => 'delete')); ?>" onsubmit="return confirm('削除しますか?');">
                                    <a hidden class="btn btn-success" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'edit', 'id' => $item['id'])); ?>">Edit</a>
                                    <input type="hidden" name="redirect" value="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>"/>
                                    <input type="hidden" name="user_id" value="<?php echo $item['id']; ?>"/>
                                    <input type="hidden" name="request_name" value="delete_user"/>
                                    <a href="#" class="btn-submit btn btn-danger"  onclick="$(this).parent().submit()"><i class="bi bi-trash" ></i>削除</a>
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

    <script>/*new DataTable('#my_table');*/</script>
    
            <script language="javascript">
                /*$(document).ready(function(){
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
                });*/
            </script>
<?php include_once('widgets/footer.php'); ?>