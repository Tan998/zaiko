<?php if (!defined('IN_SITE')) die ('The request not found');

    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
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
        <h1>コード画像のダウンロード</h1>
		<form method="POST" id="main-form3" class="form-control" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'csv/export_action', 'a' => 'export_QRlist')); ?>">
			<a class="btn btn-success" onclick="$('#main-form3').submit()" href="#">CSV download</a>
            <input type="hidden" name="request_name" value="CSV_download"/>
		</form>
</div>

<script>new DataTable('#my_table1');</script>
