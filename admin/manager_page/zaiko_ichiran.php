<?php if (!defined('IN_SITE')) die ('The request not found');

    ?>
 
    <?php 
    include_once('widgets/header.php');
    include_once('./database/zaikosuu_db.php');
     ?>
    
    <?php 
    // Lấy danh sách all hang trong kho
    //vi du echo db_create_sql("SELECT * FROM tb_user {where}", array('id' => '1'));
    //$sql = db_create_sql("SELECT * FROM tb_user {where} LIMIT {$paging['start']}, {$paging['limit']}");
    $sql = "SELECT hanghoa.id,hanghoa_ct.bin_code, hanghoa.TenHang, hanghoa_ct.hokanbasho, hanghoa_ct.joutai,hanghoa_ct.note, hanghoa_ct.create_date, hanghoa_img.img_base64 FROM (hanghoa INNER JOIN hanghoa_ct ON hanghoa.bin_code = hanghoa_ct.bin_code) INNER JOIN hanghoa_img ON hanghoa_ct.bin_code = hanghoa_img.bin_code GROUP BY hanghoa_ct.id ORDER BY hanghoa.id desc";
    $result = db_get_list($sql);
    function getItem_img($bin_code){
        $sql2 = "SELECT img_base64 FROM hanghoa_img WHERE bin_code =" . "'".$bin_code."'";
        $result = db_get_row($sql2);
        if ($result) {
            return $result['img_base64'];
        }
        else{return create_link(base_url('admin/img/no-photo.jpeg'));}
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
        <style>
            body {
                margin-bottom: 95px;
            }
            .zaikosuu , .status{
                font-size: 12px;
                background-color: #f1f1f1;
                color: black;
            }
            table{
                background-color: white;
            }
            .table>tbody {
                padding: 0;
            }
            .table>tbody>tr {
                padding-left: 0;
            }
            .card img {
                max-width: 110px;
                height: auto;
            }
            .border-2 {
                border-color: #6c757d!important;
            }
        </style>
    </head>
    <body id="zaiko_ichiran_lazy">
    
    <div class="container-fruid">
        <div class="col-12 row bg-white">
                <div class="my-3">
                    <h4>在庫一覧</h4>
                    <div class="border-bottom border-3"></div>
                </div>
            <table class="my_table_all table table-hover table-borderless row" id="my_table">
                    <thead class="col-12">
                        <tr class="text-center">
                            <th>　</th>
                        </tr>
                    </thead>
                    <tbody class="col-12 row">
                        <?php // VỊ TRÍ 02: CODE HIỂN THỊ NGƯỜI DÙNG ?>
                        <?php foreach ($result as $item){ 
                                $zaikosuu = db_get_row_zaikosuu($item['bin_code']);
                            ?>
                        <tr class="text-center col-12 row">
                            <td class="col-12">
                                <a class="col-12" href="<?php echo create_link(base_url('admin'), array('m' => 'item', 'a' => 'item_detail', 'item_code' => $item['bin_code'])); ?>">
                                    <div class="card border-2 col-12">
                                        <div class="col-12 text-white border-bottom bg-secondary bg-gradient d-flex justify-content-between"><p> </p></div>
                                        <div class="col-12 row g-0 p-1">
                                            <!---->
                                            <div class="col-sm-2 d-flex justify-content-center align-items-center border">
                                              <img class="col-12" src="<?php echo getItem_img($item['bin_code'])?getItem_img($item['bin_code']):"img/no-photo.jpeg"; ?>"  alt="...">
                                            </div>
                                            <div class="col-sm-1"></div>
                                            <div class="col-sm-9 text-start">
                                              <div class="h-100 d-flex flex-column justify-content-between">
                                                <div class="col-12">
                                                    <p class="item_name">商品名: <?php echo $item['TenHang']; ?></p>
                                                    <small class="text-muted">
                                                        <span class="item_name">コードの値：<?php echo $item['bin_code']; ?></span>
                                                    </small>
                                                </div>
                                                <p><span class="zaikosuu border rounded-pill px-1 mb-1">現在の在庫数</span> : <span class="fs-5"><?php if($zaikosuu){echo $zaikosuu['TongSLTon'];} else {echo "0";} ?></span></p>
                                              </div>
                                            </div>
                                            <!---->
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
    </div>
                <script>
                    /*//new DataTable('#my_table');
                    $(document).ready(function(){
                    $('#my_table').dataTable({
                    'order' :[]
                        })
                  });*/
                </script>
    </body>
</html>

                