<?php
	db_connect();
	$sql = "SELECT hanghoa.TenHang,hanghoa.MaHang,hanghoa_ct.note, hanghoa_ct.bin_code, qr_tb.data_url FROM hanghoa INNER JOIN hanghoa_ct ON hanghoa.bin_code = hanghoa_ct.bin_code INNER JOIN qr_tb ON hanghoa_ct.bin_code = qr_tb.MaHang;";
    $item_data = mysqli_query($conn, $sql);
	//$sql = "SELECT * from hanghoa";
		$delimiter = ",";
		$filename = "QRlist" . date('Y-m-d') . ".csv";
		//create a file pointer
		$f = fopen('php://memory', 'w');
		//set column header
		$fields = array('QR画像','BarCode','コードの値','商品名','備考');
		//$fields = array('商品ID','商品名');
		fputcsv($f, $fields, $delimiter);
		$count = 1;
		while($row = $item_data->fetch_assoc()){
			$lineData = array('=IMAGE("https://api.qrserver.com/v1/create-qr-code/?size=150x150&data="&"'.$row["bin_code"].'")','=IMAGE("https://barcodeapi.org/api/auto/"&"'.$row["bin_code"].'")',$row["bin_code"],$row["TenHang"],$row["note"]);
			//$lineData = array($row["MaHang"],$row["TenHang"]);
			fputcsv($f,$lineData,$delimiter);
		}
		//move back to beginning of file
		fseek($f, 0);

		//set headers to download file rather than display it
		header('Content-Encoding: UTF-8');
		header('Content-type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename="'.$filename. '";');
		echo "\xEF\xBB\xBF";
		//output all remaining data on a file pointer
		fpassthru($f);
		exit();
 ?>