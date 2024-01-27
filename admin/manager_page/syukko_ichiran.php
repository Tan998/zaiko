<?php if (!defined('IN_SITE')) die ('The request not found');

    ?>
 
    <?php include_once('widgets/header.php'); ?>
 
    <?php 
    // Lấy danh sách all hang trong kho
    //vi du echo db_create_sql("SELECT * FROM tb_user {where}", array('id' => '1'));
    //$sql = db_create_sql("SELECT * FROM tb_user {where} LIMIT {$paging['start']}, {$paging['limit']}");
    $sql = "SELECT hanghoa.id, hanghoa.bin_code,xuatkho_ct.STT,hanghoa.MaHang,hanghoa.DVT, hanghoa.TenHang, xuatkho_ct.SLXuat,xuatkho_ct.kikaku,xuatkho_ct.sunpo,xuatkho_ct.color, xuatkho.NgayXuat,xuatkho_ct.update_time, xuatkho_ct.NguoiPhuTrach
                            FROM hanghoa INNER JOIN (xuatkho INNER JOIN xuatkho_ct ON xuatkho.SoPhieuX = xuatkho_ct.SoPhieuX) ON hanghoa.MaHang = xuatkho_ct.MaHang
                            WHERE xuatkho.NgayXuat<= CURRENT_DATE order by xuatkho.NgayXuat desc,xuatkho_ct.STT desc";
    $users = db_get_list($sql);
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    </head>
    <body>
    
                <table class="my_table_all table table-hover table-bordered" id="my_table2">
                    <thead>
                        <tr class="text-center">
                            <th>　</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php // VỊ TRÍ 02: CODE HIỂN THỊ NGƯỜI DÙNG ?>
                        <?php foreach ($users as $item){ ?>
                        <tr class="text-center">
                            <td>
                                <a class="col-12" href="<?php echo create_link(base_url('admin'), array('m' => 'remove_item', 'a' => 'edit_remove_item', 'id' => $item['STT'])); ?>">
                                    <div class="card col-12">
                                      <div class="col-12 row g-0 p-1">
                                        <div class="col-sm-12 text-start">
                                          <div class="h-100 row">
                                            <div class="col-12 border-bottom">
                                                <span>出庫ID: <?php echo $item['STT']; ?></span>
                                                <h5 class="card-title">担当者: <?php echo $item['NguoiPhuTrach']; ?></h5>
                                            </div>
                                            <div class="status_div">
                                                <p class="card-text text-start"><span class="status border rounded-pill px-1 mb-1">status</span></p>
                                                <div class="card-text row">
                                                    <small class="col-6 text-muted border-end">
                                                        <span class="item_name"><?php echo $item['TenHang']; ?> /</span>
                                                        <span><?php echo $item['bin_code']; ?></span><br>
                                                        <span>データ更新日: <?php echo $item['update_time']; ?></span>
                                                    </small>
                                                    <div class="col-6 card-text text-end">
                                                        <span>出庫日</span> : <span><?php echo $item['NgayXuat']; ?></span><br>
                                                        <span>出庫数</span> : <span><?php echo $item['SLXuat']; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <script>
                    //new DataTable('#my_table2');
                    $(document).ready(function(){
                    $('#my_table2').dataTable({
                    'order' :[] })
                  });
                </script>
    </body>
</html>

