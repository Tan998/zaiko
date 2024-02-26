<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
 
<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_admin()){
	echo "<script>alert('この機能はアクセスできません。');"."window.location = '".create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard'))."';</script>";
}
?>
 
<?php
$id = isset($_GET['id']) ? $_GET['id'] : "" ;

//lay thong tin item
$sql = "SELECT * FROM xuatkho_ct inner join xuatkho on xuatkho.SoPhieuX = xuatkho_ct.SoPhieuX WHERE xuatkho_ct.STT = '$id' ";
$item_data = db_get_list($sql);


// Biến chứa lỗi
$error = array();
$error2 = array();

// Nếu người dùng submit form
if (is_submit('edit_item'))
{   
	$id = isset($_GET['id']) ? $_GET['id'] : "" ;
	date_default_timezone_set('Asia/Tokyo');
	//入荷日
	// Lấy danh sách dữ liệu từ form
	$data2 = array(
	'SLXuat'  => input_post('remove_item_number'),
	'NguoiPhuTrach'  => input_post('torihikisaki'),
	'update_time'  => date("Y-m-d H:i:s"),
	'acc_action' => get_current_username(),
	'memo' => input_post('memo'),
	'kikaku' => input_post('shiiretanka'),
	
	);
	// require file xử lý database cho user
	require_once('database/remove_item.php');

	$error2 = db_removeItem_ct_validate($data2);

	// Nếu validate không có lỗi
	if ($id != "" && !$error2)
	{
		if (db_update_xuatkhoCT('xuatkho_ct', $data2, $id)){ 
			?>
			<script language="javascript">
				alert('情報を更新しました。!');
				window.location = '<?php echo create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard', 'syukko-ichiran' => 'true')); ?>';
			</script>
			<?php
			die();
		}
	}
}
?>
<?php include_once('widgets/header.php'); ?>

<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'dashboard')); ?>">Home</a></li>
	    <li class="breadcrumb-item active" aria-current="page">入庫情報の編集</li>
	  </ol>
	</nav>
<div class="container bg-white mb-5">
	<div class="px-5 py-2">
		<div class="my-3">
			<h4>出庫対象の情報</h4>
			<div class="border-bottom border-3"></div>
		</div>
		<?php foreach ($item_data as $item){ ?>
			<form id="main-form" method="post" onsubmit="return confirm('この情報で出庫しますか？');" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'remove_item', 'a' => 'edit_remove_item', 'id' => $id)); ?>">
				<div class="mb-3">
					<span>出庫ID: <?php echo $item['STT']; ?> </span>
				</div>
				
				<div class="mb-3">
					<label for="torihikisaki" class="form-label"><strong>取引先</strong></label>
					<span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
					<input required type="text" class="form-control" id="torihikisaki" placeholder="取引先を入力" name="torihikisaki" value="<?php echo $item['NguoiPhuTrach']; ?>" />
					<?php show_error($error2, 'NguoiPhuTrach'); ?>
				</div>
				<div class="mb-3">
					<label for="memo" class="form-label"><strong>出庫メモ</strong><small>250文字まで</small></label>
					<textarea class="form-control" id="memo" placeholder="出庫メモを入力" name="memo" value=""><?php echo $item['memo']; ?></textarea>
					<?php //show_error($error, 'memo'); ?>
				</div>
				<h5><u>出庫対象一覧</u></h5>
				<div class="row">
					<div class="col-12 mb-3">
						<label for="bin_code_val" class="form-label bg-light bg-gradient border rounded-pill text-center px-1">商品の値</label>
						<span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
						<input disabled type="text" class="form-control" id="bin_code_val" value="<?php echo $item['bin_code']; ?>">
						<input hidden type="text" name="MaHang" value="<?php echo $item['bin_code']; ?>">
						<input hidden type="text" name="bin_code_val" value="<?php echo $item['bin_code']; ?>">
						<?php //show_error($error, 'remove_item_number'); ?>
					</div>
					<div class="col-12 col-sm-6 mb-3">
						<label for="remove_date" class="form-label px-1"><strong>出庫日</strong></label>
						<span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
						<input disabled type="date" value="<?php echo $item['NgayXuat']; ?>" class="form-control" id="remove_date" name="remove_date" />
						<?php //show_error($error, 'remove_date'); ?>
					</div>
					<div class="col-12 col-sm-6 mb-3">
						<label for="remove_item_number" class="form-label bg-light bg-gradient border rounded-pill text-center px-1">出庫数</label>
						<span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
						<input type="text" class="form-control" name="remove_item_number" id="remove_item_number" min="1" max="999" required value="<?php echo $item['SLXuat']; ?>">
						<?php show_error($error2, 'SLXuat'); ?>
						<input hidden type="text" name="MaHang" value="<?php print(input_post('bin_code_val')); ?>">
						<input hidden type="text" name="bin_code_val" value="<?php print(input_post('bin_code_val')); ?>">
						<?php //show_error($error, 'remove_item_number'); ?>
					</div>
				</div>
				<div class="mb-3">
					<label for="shiiretanka" class="form-label">仕入単価</label>
					<input type="text" class="form-control" id="shiiretanka" name="shiiretanka" value="<?php echo $item['kikaku']; ?>">
					<?php //show_error($error, 'shiiretanka'); ?>
				</div>
				<div>
					<input hidden type="text" class="form-control" id="qr_img_data" name="qr_img_data" type="text"/>
				</div>
				<div class="mb-3">
					<a class="btn btn-success" onclick="$('#main-form').submit()" href="#">保存</a>
						<input type="hidden" name="request_name" value="edit_item"/>
						<a class="btn btn-secondary" href="#" onclick="window.history.go(-1); return false;">戻る</a>
				</div>
			</form>
			<form method="POST" class="form-delete" action="<?php //echo create_link(base_url('admin/index.php'), array('m' => 'remove_item', 'a' => 'delete_remove_item')); ?>">
				<input type="hidden" name="id" value="<?php echo $item['STT']; ?>"/>
	            <input type="hidden" name="request_name" value="delete_remove_item"/>
	            <a href="#" class="btn-submit btn btn-outline-danger"><i class="bi bi-trash"></i></a>
            </form>
		<?php } ?>
	</div>
</div>

<script language="javascript">
$(document).ready(function(){
  // Nếu người dùng click vào nút delete
  // Thì submit form
  $('.btn-submit').click(function(){
  $(this).parent().submit();
  return false; });
               
  // Nếu sự kiện submit form xảy ra thì hỏi người dùng có chắc không?
  $('.form-delete').submit(function(){
    if (!confirm('Confirm to delete?')){
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