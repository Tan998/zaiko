<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
 
<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_logged()){
	redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}

function get_zaikosuu($bin_code_val){
	$sql = "SELECT Q1.id, Q1.MaHang,Q1.bin_code, Q1.TenHang, Q1.DVT, Q1.NhaCC, Sum(Q1.SLTon) AS TongSLTon 
					FROM (
						SELECT hanghoa.id, hanghoa.MaHang, hanghoa.bin_code, hanghoa.TenHang,hanghoa.DVT,hanghoa.NhaCC, nhapkho_ct.SLNhap as SLTon, nhapkho.NgayNhap FROM (hanghoa INNER JOIN nhapkho_ct ON hanghoa.MaHang = nhapkho_ct.MaHang) INNER JOIN nhapkho ON nhapkho_ct.SoPhieuN = nhapkho.SoPhieuN WHERE nhapkho.NgayNhap <= CURRENT_DATE and nhapkho_ct.bin_code = '$bin_code_val'
						union all
						SELECT hanghoa.id, hanghoa.MaHang,hanghoa.bin_code, hanghoa.TenHang,hanghoa.DVT,hanghoa.NhaCC, (-1)*xuatkho_ct.SLXuat as SLTon, xuatkho.NgayXuat FROM hanghoa INNER JOIN (xuatkho INNER JOIN xuatkho_ct ON xuatkho.SoPhieuX = xuatkho_ct.SoPhieuX) ON hanghoa.MaHang = xuatkho_ct.MaHang WHERE xuatkho.NgayXuat<= CURRENT_DATE and xuatkho_ct.bin_code = '$bin_code_val') AS Q1 GROUP BY Q1.id;";
	$querry = db_get_list($sql);
	foreach ($querry as $data){
	echo $data['TongSLTon'];
	}
}
?>
 
<?php include_once('widgets/header.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
			integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
			crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/script.js" defer></script>
<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
		<style>
			#spinner {
				display: none;
			}
					</style>
<h1>出庫</h1>
<div class="container mb-3">
	<div class="row d-flex justify-content-center">
		<div class="card text-center px-2 py-2">
			<!-- Camera Scan -->
			<div class="card-body">
				<h3 class="card-title">コードを読み取る</h3>
				<div class="cv-bf">
					<canvas hidden="" style="width:100%;" id="qr-canvas"></canvas>
				</div>
				<div>
					<p class="fs-6 text-muted">(カメラのズームを利用してください。)</p>
					<a role="button" id="btn-scan-qr" class="btn btn-outline-warning border border-4 rounded border-warning">
						<div class="">
							<i class="fs-1 bi bi-qr-code-scan"></i>
						</div>
					</a>
				</div>
				<div id="qr-result" hidden="">
					<b>Data:</b> <span id="code_value"></span>
				</div>
				
				<script src="js/qrCodeScanner.js"></script>
			</div>
			<!-- Camera Scan -->
			<!-- input img -->
			<div id="qr-result" hidden="">
				<b>Data:</b> <span id="code_value"></span>
			</div>
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

<div class="container card mb-5">
	<form id="myform" class="my-3" action="" method="POST">
		<label for="bin_code_val" class="form-label mb-2">商品の値</label>
		<input type="text" name="bin_code_val" id="bin_code_val" value="">
		<input class="btn border border-info" type="submit" name="remove_item_submit" value="次へ">
	</form>
<?php 
if (isset($_POST['remove_item_submit'])) {
	$bin_code_val = isset($_POST['bin_code_val']) ? $_POST['bin_code_val'] : "" ;
	
	if ($bin_code_val != "") {
		$sql = "SELECT * FROM hanghoa WHERE hanghoa.bin_code = '$bin_code_val' ";
	    $item_data = db_get_list($sql);
	    if (count($item_data) > 0) { 
	    	echo "<strong>商品のコードの値：</strong>" .$bin_code_val ."<br>";
	    	?>
	    	<form method="POST" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'remove_item', 'a' => 'remove_item_check')); ?>" >
	    		<label for="add_item_value" class="form-label mb-2">出庫数量を入力</label>
	    		<div class="row text-center mb-2 d-flex align-items-center">
	    			<div class="col-12">
	    				<span class="col-2 bg-light bg-gradient border rounded-pill text-center">在庫数: 　<u><strong><?php get_zaikosuu($bin_code_val); ?></strong></u></span>
		    			<span class="col-1">- </span>
		    			<input hidden type="text" name="bin_code_val" value="<?php echo $bin_code_val ?>">
		    			<input class="col-6" type="number" min="0" max="999" required name="remove_item_number" placeholder="出庫数を入力してください。" value="" class="form-control" id="remove_item_value">
	    			</div>
	    		</div>
				<input class="btn btn-success" type="submit" name="remove_item_check" value="出庫">
			</form>
<?php 	}
	    else{
	    	echo "<script>
	    	alert('この商品まだ登録されません。新規登録してください。');
	    	window.location.href = window.location.href;
	    	</script>";
	    }
	}
}
?>
	<div class="text-end mt-5 mb-2">
		<br>
		<a class="btn btn-secondary" onclick="javascript:(function() {window.location.href = window.location.href; })()">ページを更新</a>
	</div>
	


</div>

<?php include_once('widgets/footer.php'); ?>
