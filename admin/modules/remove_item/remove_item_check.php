<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
 
<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_logged()){
	redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
?>
 
<?php
if (isset($_POST['remove_item_check'])) {
	$remove_item_number = isset($_POST['remove_item_number']) ? $_POST['remove_item_number'] : "";
	$bin_code_val = isset($_POST['bin_code_val']) ? $_POST['bin_code_val'] : "";

}


// Biến chứa lỗi
$error = array();
$error2 = array();

// Nếu người dùng submit form
if (is_submit('add_qr'))
{   
	date_default_timezone_set('Asia/Tokyo');
	//入荷日
	$today = date("Ymd");
	$remove_date = strtotime(input_post('remove_date'));
	$remove_dateSS = date('Ymd', strtotime($_POST['remove_date']));
	if ($remove_dateSS <= $today) {
	  $remove_date = date('Y-m-d', $remove_date);

	  //出荷ID
		$remove_dateID = date('Ymd',strtotime($remove_date));
		$remove_ID= $remove_dateID;
	}
	// Lấy danh sách dữ liệu từ form
	$data = array(
	'SoPhieuX'  => $remove_ID,
	'NgayXuat'  => $remove_date,
	);
	$data2 = array(
	'SoPhieuX'     => $remove_ID,
	'MaHang'  => input_post('bin_code_val'),
	'bin_code'     => input_post('bin_code_val'),
	'SLXuat'  => input_post('remove_item_number'),
	'NguoiPhuTrach'  => input_post('torihikisaki'),
	'update_time'  => date("Y-m-d H:i:s"),
	'acc_action' => get_current_username(),
	'memo' => input_post('memo'),
	'kikaku' => input_post('shiiretanka'),
	
	);
	// require file xử lý database cho user
	require_once('database/remove_item.php');
	 
	// Thực hiện validate
	$error = db_removeItem_validate($data);

	$error2 = db_removeItem_ct_validate($data2);

	if (!$error) {
		db_insert('xuatkho', $data);
	}
	// Nếu validate không có lỗi
	if (!$error2)
	{
		if (db_insert('xuatkho_ct', $data2)){ 
			?>
			<script language="javascript">
				alert('出庫完了しました。!');
				window.location = '<?php echo create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard', 'syukko-ichiran' => 'true')); ?>';
			</script>
			<?php
			die();
		}
	}
}
?>
<?php include_once('widgets/header.php'); ?>

<h1>出庫対象を確認</h1>
<div class="container-fruid bg-white">
	<div class="px-5 py-2">
			<form id="main-form" method="post" onsubmit="return confirm('この情報で出庫しますか？');" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'remove_item', 'a' => 'remove_item_check')); ?>">
				<div class="mb-3">
					<label for="torihikisaki" class="form-label"><strong>取引先</strong></label>
					<span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
					<input required type="text" class="form-control" id="torihikisaki" placeholder="取引先を入力" name="torihikisaki" value="<?php echo get_current_username(); ?>" />
					<?php show_error($error2, 'NguoiPhuTrach'); ?>
				</div>
				<div class="mb-3">
					<label for="memo" class="form-label"><strong>出庫メモ</strong><small>250文字まで</small></label>
					<textarea class="form-control" id="memo" placeholder="出庫メモを入力" name="memo" value=""><?php echo input_post('memo'); ?></textarea>
					<?php //show_error($error, 'memo'); ?>
				</div>
				<h5>出庫対象一覧</h5>
				<div class="row">
					<div class="col-12 mb-3">
						<label for="bin_code_val" class="form-label bg-light bg-gradient border rounded-pill text-center px-1">商品の値</label>
						<span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
						<input disabled type="text" class="form-control" id="bin_code_val" value="<?php echo input_post('bin_code_val'); ?>">
						<input hidden type="text" name="MaHang" value="<?phpecho echo input_post('bin_code_val'); ?>">
						<input hidden type="text" name="bin_code_val" value="<?php echo input_post('bin_code_val'); ?>">
						<?php show_error($error, 'bin_code_val'); ?>
					</div>
					<div class="col-6 mb-3">
						<label for="remove_date" class="form-label px-1"><strong>出庫日</strong></label>
						<span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
						<input required type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" id="remove_date" name="remove_date" />
						<?php //show_error($error, 'remove_date'); ?>
					</div>
					<div class="col-6 mb-3">
						<label for="remove_item_number" class="form-label bg-light bg-gradient border rounded-pill text-center px-1">出庫数</label>
						<span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
						<input disabled type="text" class="form-control" id="remove_item_number" value="<?php echo input_post('remove_item_number'); ?>">

						<input hidden type="text" name="remove_item_number" value="<?php echo input_post('remove_item_number'); ?>">
						<input hidden type="text" name="MaHang" value="<?phpecho echo input_post('bin_code_val'); ?>">
						<input hidden type="text" name="bin_code_val" value="<?php echo input_post('bin_code_val'); ?>">
						<?php show_error($error2, 'SLXuat'); ?>
					</div>
				</div>
				<div class="mb-3">
					<label for="shiiretanka" class="form-label">仕入単価</label>
					<input type="text" class="form-control" id="shiiretanka" name="shiiretanka" value="<?php echo input_post('shiiretanka'); ?>">
					<?php //show_error($error, 'shiiretanka'); ?>
				</div>
				<div>
					<input hidden type="text" class="form-control" id="qr_img_data" name="qr_img_data" type="text"/>
				</div>
				<div class="mb-3">
					<a class="btn btn-success" onclick="$('#main-form').submit()" href="#">Save</a>
						<input type="hidden" name="request_name" value="add_qr"/>
						<a class="btn btn-secondary" href="#" onclick="window.history.go(-2); return false;">戻る</a>
				</div>
			</form>
	</div>
</div>

<?php include_once('widgets/footer.php'); ?>