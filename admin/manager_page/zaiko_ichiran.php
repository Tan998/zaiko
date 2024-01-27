<?php if (!defined('IN_SITE')) die ('The request not found');

    ?>
 
    <?php include_once('widgets/header.php'); ?>
 
    <?php 
    // Lấy danh sách all hang trong kho
    //vi du echo db_create_sql("SELECT * FROM tb_user {where}", array('id' => '1'));
    //$sql = db_create_sql("SELECT * FROM tb_user {where} LIMIT {$paging['start']}, {$paging['limit']}");
    $sql = "SELECT Q1.id, Q1.MaHang,Q1.bin_code, Q1.TenHang, Q1.DVT, Q1.NhaCC, Sum(Q1.SLTon) AS TongSLTon 
					FROM (
						SELECT hanghoa.id, hanghoa.MaHang, hanghoa.bin_code, hanghoa.TenHang,hanghoa.DVT,hanghoa.NhaCC, nhapkho_ct.SLNhap as SLTon, nhapkho.NgayNhap FROM (hanghoa INNER JOIN nhapkho_ct ON hanghoa.MaHang = nhapkho_ct.MaHang) INNER JOIN nhapkho ON nhapkho_ct.SoPhieuN = nhapkho.SoPhieuN WHERE nhapkho.NgayNhap <= CURRENT_DATE 
						union all
						SELECT hanghoa.id, hanghoa.MaHang,hanghoa.bin_code, hanghoa.TenHang,hanghoa.DVT,hanghoa.NhaCC, (-1)*xuatkho_ct.SLXuat as SLTon, xuatkho.NgayXuat FROM hanghoa INNER JOIN (xuatkho INNER JOIN xuatkho_ct ON xuatkho.SoPhieuX = xuatkho_ct.SoPhieuX) ON hanghoa.MaHang = xuatkho_ct.MaHang WHERE xuatkho.NgayXuat<= CURRENT_DATE ) AS Q1 GROUP BY Q1.id;";
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
            .item_name {
                display: block;
                width: 330px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;   
            }
            @media screen and (min-width: 320px) {
              .item_name {
                width: 150px;
            }
            .item_name:hover{
                width: 100%;
                white-space: wrap;
                overflow: visible;
            }
        </style>
    </head>
    <body>
    
                <table class="my_table_all table table-hover table-bordered" id="my_table">
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
                            	<a class="col-12" href="<?php echo create_link(base_url('admin'), array('m' => 'zaiko_ichiran', 'a' => 'update', 'id' => $item['id'])); ?>">
                                    <div class="card col-12">
                                      <div class="col-12 row g-0 p-1">
                                        <div class="col-sm-2">
                                          <img class="col-12" src="https://www.freeiconspng.com/uploads/no-image-icon-11.PNG"  alt="...">
                                        </div>
                                        <div class="col-sm-10 text-start">
                                          <div class="h-100">
                                            <div class="col-12">
                                                <h5 class="item_name card-title"><?php echo $item['TenHang']; ?></h5>
                                            </div>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <span><?php echo $item['NhaCC']; ?> /</span>
                                                    <span><?php echo $item['bin_code']; ?></span>
                                                </small></p>
                                            <p class="card-text text-end"><span class="zaikosuu border rounded-pill px-1 mb-1">現在の在庫数</span> : <span class="fs-4"><?php echo $item['TongSLTon']; ?></span></p>
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
                    //new DataTable('#my_table');
                    $(document).ready(function(){
                    $('#my_table').dataTable({
                    'order' :[] })
                  });
                </script>
    </body>
</html>

                