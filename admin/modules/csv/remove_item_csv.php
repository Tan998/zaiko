<?php if (!defined('IN_SITE')) die ('The request not found');

    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
?>
<?php
$sql = "SELECT hanghoa.id, hanghoa.bin_code,nhapkho_ct.STT,hanghoa.MaHang,hanghoa.DVT, hanghoa.TenHang, nhapkho_ct.SLNhap,nhapkho_ct.kikaku,nhapkho_ct.sunpo,nhapkho_ct.color, nhapkho.NgayNhap,nhapkho_ct.update_time, nhapkho_ct.NguoiPhuTrach
                            FROM hanghoa INNER JOIN (nhapkho INNER JOIN nhapkho_ct ON nhapkho.SoPhieuN = nhapkho_ct.SoPhieuN) ON hanghoa.MaHang = nhapkho_ct.MaHang
                            WHERE nhapkho.NgayNhap<= ".date("Ymd")." order by nhapkho.NgayNhap desc,nhapkho_ct.STT desc";
$result = db_get_list($sql);
?>
 <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <script type="text/javascript" src="./js/jquery.qrcode.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
</head>
<div class="mb-5">
        <h1>データのエクスポート年月の選択</h1>
		<form method="POST" id="main-form2" class="form-control" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'csv/export_action', 'a' => 'remove_csv_act')); ?>">
            <div class="col-sm-6">
                <label for="year_month" class="form-label">データのエクスポート年月の選択:</label>
                <input class="form-control" type="month" id="year_month" min="2023-01" max="2099-12" required name="year_month" placeholder="----年 --月">
            </div>
			<a class="btn btn-success" onclick="$('#main-form2').submit()" href="#">CSV download</a>
            <input type="hidden" name="request_name" value="CSV_download"/>
		</form>
</div>

<script>new DataTable('#my_table1');</script>
