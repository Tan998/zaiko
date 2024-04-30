<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
 
<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_logged()){
	redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
include_once('./database/zaikosuu_db.php');

$item_code = isset($_GET['item_code']) ? $_GET['item_code'] : "" ;
?>
 
<?php include_once('widgets/header.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
			integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
			crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/script.js" defer></script>
<!-- Camera front/back option
<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
-->
<!--<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>-->

<script src="./js/html5-qrcode.js" type="text/javascript"></script>
		<style>
			#spinner {
				display: none;
			}
		</style>
<h1>出庫</h1>
<div class="container mb-3">
	<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'dashboard')); ?>">Home</a></li>
	    <li class="breadcrumb-item active" aria-current="page">コードのスキャン</li>
	  </ol>
	</nav>
	<div id="scan_container_id" class="">
		<div class="card text-center px-2 py-2 border_radius_1">
				<!-- Camera Scan -->
				<div class="card-body">
					<h3 class="card-title">コードの読み込み</h3>
					<div class="row d-flex justify-content-center">
						<div class="col-12">
							<a role="button" id="btn-scan-qr" class="btn btn-outline-warning border border-4 rounded border-warning">
								<div class="">
									<i class="fs-1 bi bi-qr-code-scan"></i>
								</div>
							</a>
						</div>
						<div class="col-lg-6 row" id="scanner_box">
							<div id="qr-reader" width="100%"></div>
							<span id="qr-reader-results"></span>
						</div>
					<script src="js/qrCodeScanner.js"></script>
				</div>
				<!-- Camera Scan -->
				<!-- input img -->
				または <br> コード画像のアップロード
				<div class="add_file_area my-2">
					<label for="qr-input-file" class="btn btn-outline-warning border border-4 rounded border-warning">
						<i class="fs-1 bi bi-file-earmark-arrow-up"></i>
					</label>
					<div id="reader" style="display: none;"></div>
					<input hidden class="input_file" type="file" id="qr-input-file" accept="image/*">
					<script src="js/input_code.js"></script>
				</div>
				<!-- input img -->
			</div>
		</div>
	</div>

	<div class="container card my-2 mb-5 border_radius_1">
		<form id="myform" class="my-3 row" action="" method="POST">
			<label for="bin_code_val" class="form-label mb-2">商品番号　</label>
			<div class="col-sm-6">
				<!-- serch -->
				<div class="input-group mb-3">
				 	<input type="text" name="bin_code_val" id="bin_code_val" class="form-control" placeholder="商品番号を入力" aria-label="" aria-describedby="button-addon2" value="<?php echo $item_code; ?>">
				 	<input class="btn btn-dark" type="submit" id="button-addon2" name="remove_item_submit" value="検索">
				</div>
			</div>
			<!-- Spinner -->
		    <div class="d-flex justify-content-center align-items-center">
				<div id="spinner" class="spinner-border text-warning" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</form>
	<?php 
	if (isset($_POST['remove_item_submit'])) {
		$bin_code_val = isset($_POST['bin_code_val']) ? $_POST['bin_code_val'] : "" ;
		
		$zaikosuu = db_get_row_zaikosuu($bin_code_val);
		if ($bin_code_val != "") {
			$sql = "SELECT * FROM hanghoa WHERE hanghoa.bin_code = '$bin_code_val' ";
		    $item_data = db_get_list($sql);
		    if (count($item_data) > 0) { 
		    	echo "
		    	<div class='rounded border border-3 p-2'>
		    		<strong>商品番号：".$bin_code_val ."</strong><br>";
		    	?>
		    	<form method="POST" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'remove_item', 'a' => 'remove_item_check')); ?>" >
		    		<div class="container">
		    			<div class="col-12 d-flex justify-content-between row">
		    				<p class="col-5 bg-light bg-gradient border rounded-pill text-center my-2 p-1">在庫数: 　<u><strong><span id="zaikosuu"><?php if($zaikosuu){echo $zaikosuu['TongSLTon'];} else {echo "0";} ?></span></strong></u></p>
		    				<?php if($zaikosuu && $zaikosuu['TongSLTon'] > 0) { ?>
			    			<span class="col-1 my-2 d-flex justify-content-center align-items-center"><strong>―</strong></span>
			    			<input hidden type="text" name="bin_code_val" value="<?php echo $bin_code_val ?>">
			    			<input hidden type="text" name="zaikosuu" value="<?php print($zaikosuu['TongSLTon']);?>">
			    			<input class="col-5 my-2" type="number" min="1" max="999" required name="remove_item_number" placeholder="出庫数を入力してください。" value="" class="form-control" id="remove_item_value" data-bs-toggle="popover" title="ご注意ください" data-bs-placement="top" data-bs-content="出荷数量は在庫数量を超えることはできません">
			    			<div class="text-end">
								<input class=" my-2 btn btn-success" type="submit" name="remove_item_check" value="登録完了へ">
							</div>
							<?php }
							else { ?><p style="color:white;" class="col-sm-7 bg-secondary bg-gradient border rounded-pill text-center p-1 my-2">在庫量が足りないため機能をご利用できません</p><?php } ?>
		    			</div>
		    		</div>
				</form>
	<?php 	echo "</div>";}
		    else{
		    	if (is_admin()) {
			    	echo "<script>
			    		if (window.confirm('この商品まだ登録されません。新規登録ページへ移動しますか？'))
							{
							    window.location.href = '". create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'add_qr')) ."';
							}
							else
							{
							    window.location.href = window.location.href;
							}
			    	</script>";
		    	}
		    	echo "<script>alert('この商品まだ登録されません。')</script>";
		    }
		}
	}
	?>
		<div class="text-end mt-5 mb-2">
			<br>
			<a class="btn btn-secondary" onclick="javascript:(function() {window.location.href = window.location.href; })()">ページを更新</a>
		</div>
	</div>
</div>
<script type="text/javascript">
/* Event listener */
var remove_item_number = document.getElementsByName("remove_item_number")[0];
if(remove_item_number){
 remove_item_number.addEventListener('change', doThing);
}
/* Function */
function doThing(){
	submit_btn = document.getElementsByName("remove_item_check")[0];
	zaikosuu = document.getElementById('zaikosuu').innerHTML;
	if ((zaikosuu - this.value) < 0) {
		submit_btn.disabled = true;
	}
	else{
		submit_btn.disabled = false;
	}
}
</script>
<script>
	//popover
	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
	var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
	 return new bootstrap.Popover(popoverTriggerEl)
	});


	$(window).load(function () {
		     $('#button-addon2').on('click',function(){
		     showSpinner();
		        // Show spinner for 1 sec
		        setTimeout(() => {
		        hideSpinner();
				}, 1000);
				$('#myform').submit();
		 });
		});
</script>
<?php include_once('widgets/footer.php'); ?>
