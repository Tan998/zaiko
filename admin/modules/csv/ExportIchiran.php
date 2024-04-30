<?php if (!defined('IN_SITE')) die ('The request not found');

    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
?>
<?php
	$sql="SELECT hanghoa.id,hanghoa.bin_code,hanghoa.TenHang,hanghoa_ct.hokanbasho,hanghoa_ct.joutai,hanghoa_ct.note FROM hanghoa INNER JOIN hanghoa_ct ON hanghoa.bin_code = hanghoa_ct.bin_code";
    $result = db_get_list($sql);
    include_once('./database/zaikosuu_db.php');
?>
 <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <script type="text/javascript" src="./js/jquery.qrcode.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
        <style>
            table {background-color: white;}
        </style>
</head>
<div class="mb-5">
        <h1>プレビュー</h1>
        <form method="POST" id="main-form" class="form-control" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'csv/export_action', 'a' => 'ExportIchiran_act')); ?>">
            <a class="btn btn-success" onclick="$('#main-form').submit()" href="#">CSV download</a>
            <input type="hidden" name="request_name" value="CSV_download"/>
        </form>
        <div class="col-sm-12 bg-light">    
                <table class="table table-hover table-bordered" id="my_table">
                    <thead>
                        <tr class="text-center table-secondary">
                            <th scope="col">商品番号</th>
                            <th scope="col">商品名</th>
                            <th scope="col">保管場所</th>
                            <th scope="col">状態</th>
                            <th scope="col">メモ</th>
                            <th scope="col">在庫数</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $rows){ 
                            $zaikosuu = db_get_row_zaikosuu($rows['bin_code']);
                            ?>

                        <tr class="text-center">
                            <td class="text-break"><?php echo $rows['bin_code']; ?></td>
                            <td class="text-break"><?php echo $rows['TenHang']; ?></td>
                            <td><?php echo $rows['hokanbasho']; ?></td>
                            <td><?php echo $rows['joutai']; ?></td>
                            <td  class="text-break"><?php echo $rows['note']; ?></td>
                            <td><?php if($zaikosuu){echo $zaikosuu['TongSLTon'];} else {echo "0";} ?></td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
        </div>
</div>

<script>/*new DataTable('#my_table');*/</script>
