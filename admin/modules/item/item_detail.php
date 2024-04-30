<?php if (!defined('IN_SITE')) die ('The request not found'); ?>


<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_logged()){
	redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}

include_once('widgets/header.php');


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$item_code = isset($_GET['item_code']) ? $_GET['item_code'] : "" ;
function get_item($bin_code_val){
	$sql = "SELECT hanghoa.id,hanghoa_ct.bin_code, hanghoa.TenHang, hanghoa_ct.hokanbasho, hanghoa_ct.joutai,hanghoa_ct.note, hanghoa_ct.create_date, hanghoa_img.img_base64 FROM (hanghoa INNER JOIN hanghoa_ct ON hanghoa.bin_code = hanghoa_ct.bin_code) INNER JOIN hanghoa_img ON hanghoa_ct.bin_code = hanghoa_img.bin_code WHERE hanghoa_ct.bin_code = '".$bin_code_val."' GROUP BY hanghoa_ct.id";
    $result = db_get_row($sql);
return $result;

}
$row = get_item($item_code);
?>



<?php 
if($row){
	include_once('./database/zaikosuu_db.php');
	$zaikosuu = db_get_row_zaikosuu($row['bin_code']);
?>
	<script>
	function CopyToClipboard(id)
	{
	var r = document.createRange();
	r.selectNode(document.getElementById(id));
	window.getSelection().removeAllRanges();
	window.getSelection().addRange(r);
	document.execCommand('copy');
	window.getSelection().removeAllRanges();
	}

	</script>
<h1>商品詳細</h1>
<div class="container mb-5">
	<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'dashboard')); ?>">Home</a></li>
	    <li class="breadcrumb-item active" aria-current="page">商品詳細</li>
	  </ol>
	</nav>
	<div class="row bg-light p-2 border_radius_1">
		<div class="col-md-6 col-sm-5 p-4 border d-flex justify-content-center">
			<img class="col-6 img-fluid" src="<?php echo $row['img_base64']?$row['img_base64'] : "img/no-photo.jpeg"; ?>" alt="">
		</div>
		<ul class="col-md-6 col-sm-7 d-flex flex-column justify-content-between list-group px-2">
			<li class="border-top">
				<span class="item-title">商品名</span><br>
				<strong class="text-break"><?php echo $row['TenHang']; ?></strong>
			</li>
			<li class="border-top">
				<span class="item-title">商品番号</span><br>
				<span id="cp_bincode"><strong><?php echo $row['bin_code']; ?></strong></span>
				<a tabindex="0" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="コピーした" onclick="CopyToClipboard('cp_bincode');return false;"><i class="bi bi-clipboard2 fs-5"></i></a>
			</li>
			<li class="border-top">
				<span class="item-title">保管場所</span><br>
				<span><?php echo $row['hokanbasho']; ?></span>
			</li>
			<li class="border-top">
				<span class="item-title">在庫数</span><br>
				<span><?php if($zaikosuu){echo $zaikosuu['TongSLTon'];} else {echo "0";} ?></span>
			</li>
			<li class="border-top border-bottom">
				<span class="item-title">登録されたの日</span><br>
				<span><?php echo $row['create_date']; ?></span>
			</li>
		</ul>
		<div class="col-12 mt-3 mb-3 px-0">
			<ul class="list-group">
				<li class="list-group-item"><p>メモ:</p>
					<p class="text-break"><?php echo $row['note']; ?></p>
				</li>
			</ul>
		</div>
		<div class="d-flex justify-content-center">
			<section class="col-sm-6 mb-3 text-start btn-group"  role="group">
	      <a class="shadow-sm btn btn-outline-primary" href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'add_item', 'a' => 'add_item', 'item_code' => $item_code)); ?>">入庫</a>
	      <a class="shadow-sm btn btn-outline-danger" href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'remove_item', 'a' => 'remove_item', 'item_code' => $item_code)); ?>">出庫</a>
	      <?php if (is_admin()) { ?>
	      <a class="shadow-sm btn btn-outline-dark" href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'edit_qr' , 'item_code' => $item_code)); ?>">情報変更</a>
	    	<?php } ?>
	    </section>
		</div>
	</div>
</div>
<?php }
else {
?>
<div class="card">
  <div class="card-body">
    <h1 class="card-title">商品なし</h1>
  </div>
  <div class="d-flex justify-content-center min-vh-100">
  	<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script><lottie-player src="img/gif/Animation-noitem.json" background="transparent" speed="1" style="width: 300px; height: 300px" direction="1" mode="normal" loop autoplay></lottie-player>
  </div>
</div>
<?php } ?>
<?php include_once('widgets/footer.php'); ?>
