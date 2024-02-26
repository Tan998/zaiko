<?php if (!defined('IN_SITE')) die ('The request not found');

    ?>
 
    <?php include_once('widgets/header.php'); ?>
 
    <?php
    if (is_admin()) {
    // Lấy danh sách all hang trong kho
    //vi du echo db_create_sql("SELECT * FROM tb_user {where}", array('id' => '1'));
    //$sql = db_create_sql("SELECT * FROM tb_user {where} LIMIT {$paging['start']}, {$paging['limit']}");
    $sql = "SELECT hanghoa.id, hanghoa.bin_code,xuatkho_ct.STT,hanghoa.MaHang,hanghoa.DVT, hanghoa.TenHang, xuatkho_ct.SLXuat, xuatkho.NgayXuat,xuatkho_ct.update_time, xuatkho_ct.NguoiPhuTrach
                            FROM hanghoa INNER JOIN (xuatkho INNER JOIN xuatkho_ct ON xuatkho.SoPhieuX = xuatkho_ct.SoPhieuX) ON hanghoa.MaHang = xuatkho_ct.MaHang
                            WHERE xuatkho.NgayXuat<= ".date("Ymd")." order by xuatkho.NgayXuat desc,xuatkho_ct.STT desc";
    $users = db_get_list($sql);
    }
    else{
    $sql = "SELECT hanghoa.id, hanghoa.bin_code,xuatkho_ct.STT,hanghoa.MaHang,hanghoa.DVT, hanghoa.TenHang, xuatkho_ct.SLXuat, xuatkho.NgayXuat,xuatkho_ct.update_time, xuatkho_ct.NguoiPhuTrach
                            FROM hanghoa INNER JOIN (xuatkho INNER JOIN xuatkho_ct ON xuatkho.SoPhieuX = xuatkho_ct.SoPhieuX) ON hanghoa.MaHang = xuatkho_ct.MaHang
                            WHERE xuatkho.NgayXuat<= ".date("Ymd")." AND xuatkho_ct.acc_action = '".get_current_username()."' order by xuatkho.NgayXuat desc,xuatkho_ct.STT desc";
    $users = db_get_list($sql);
    }
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
    <body id="syukko_ichiran_lazy">
            <div class="col-12 row bg-white">
                <div class="my-3">
                    <h4>出庫一覧</h4>
                    <div class="border-bottom border-3"></div>
                </div>
                <table class="my_table_all table table-hover table-borderless row" id="my_table2">
                    <thead class="col-12">
                        <tr class="text-center">
                            <th>　</th>
                        </tr>
                    </thead>
                    <tbody class="col-12 row">
                        <?php // VỊ TRÍ 02: CODE HIỂN THỊ NGƯỜI DÙNG ?>
                        <?php 
                            foreach ($users as $item){ ?>
                            <tr class="text-center col-12 row">
                                <td class="col-12">
                                    <a class="col-12" href="<?php echo create_link(base_url('admin'), array('m' => 'remove_item', 'a' => 'edit_remove_item', 'id' => $item['STT'])); ?>">
                                        <div class="card col-12">
                                          <div class="col-12 row g-0">
                                            <div class="col-sm-12 text-start">
                                              <div class="h-100 row">
                                                <div class="col-12 text-white border-bottom bg-secondary bg-gradient d-flex justify-content-between">
                                                    <span class="my-1">出庫ID: <?php echo $item['STT']; ?></span>
                                                    <span class="my-1">担当者: <?php echo $item['NguoiPhuTrach']; ?></span>
                                                </div>
                                                <div class="status_div px-0">
                                                    <!--<p class="card-text text-start"><span class="status border rounded-pill px-1 mb-1">status</span></p>-->
                                                    <div class="card-text row my-1">
                                                        <small class="col-6 border-end px-0 row">
                                                            <span class="item_name"><strong>商品名：<?php echo $item['TenHang']; ?></strong></span>
                                                            <span class="item_name"><strong>コードの値：<?php echo $item['bin_code']; ?></span></strong><br>
                                                            <span>データ更新日: <?php echo $item['update_time']; ?></span>
                                                        </small>
                                                        <div class="col-6 card-text text-end d-flex flex-column">
                                                            <span>出庫日: <?php echo $item['NgayXuat']; ?></span><br>
                                                            <span><strong>出庫数: <?php echo $item['SLXuat']; ?></strong></span>
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
                <div>
                    <a id="scroll_navheader" class="btn btn-secondary rounded-circle" href="#scrollheader"><i class="bi bi-chevron-double-up"></i></a>
                </div>
            </div>
                <script>
                    /*//new DataTable('#my_table2');
                    $(document).ready(function(){
                    $('#my_table2').dataTable({
                    'order' :[] })
                  });*/
                </script>
    </body>
</html>
<?php /*} else { ?>
    <html>
        <style>
        .alert_css {
          animation: blinker 2s linear infinite;
        }

        @keyframes blinker {
          50% {
            opacity: 0;
          }
        }
        </style>
    </html>
    <div class="alert_css alert alert-warning" role="alert">  
      <p class="fs-1 text-center"><i class="fs-1 bi bi-exclamation-triangle"></i> この機能にアクセスできません <i class="fs-1 bi bi-exclamation-triangle"></i></p>
    </div>
<?php } */?>
