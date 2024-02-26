<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
 
<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_logged()){
	redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
?>
 
<?php include_once('widgets/header.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
			integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
			crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/script.js" defer></script>
<!--Camera front/back option
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
<h1>スキャン検索</h1>
<div class="container mb-3">
	<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'dashboard')); ?>">Home</a></li>
	    <li class="breadcrumb-item active" aria-current="page">スキャン検索</li>
	  </ol>
	</nav>
	<div class="">
		<div class="card text-center px-2 py-2">
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
			<!-- Spinner -->
			<div class="d-flex justify-content-end align-items-center">
				<div id="spinner" class="spinner-border text-warning" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>
	</div>
</div>
	<div class="text-center mt-5 mb-2">
		<br>
		<a class="btn btn-secondary" onclick="javascript:(function() {window.location.href = window.location.href; })()">ページを更新</a>
	</div>
	
		<form hidden id="form_search_item" class="my-3 row" method="POST">
			<label for="bin_code_val" class="form-label mb-2">商品番号　</label>
			<div class="col-sm-6">
				<!-- serch -->
				<div class="input-group mb-3">
				 	<input type="text" name="bin_code_val" id="bin_code_val" class="form-control" placeholder="商品番号を入力" aria-label="" aria-describedby="button-addon2">
				 	<input class="btn btn-dark" type="submit" id="button-addon2" name="add_item_submit" value="検索">
				</div>
			</div>
		</form>
	<script>
		$(window).load(function () {
		     $('#button-addon2').on('click',function(){
		     showSpinner();
		 });
		});
	</script>

<?php include_once('widgets/footer.php'); ?>
