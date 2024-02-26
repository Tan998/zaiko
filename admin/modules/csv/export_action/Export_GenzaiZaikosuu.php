<?php
session_start();
if (isset($_SESSION['username']) && $_SESSION['username']){
	require "../connect.php";
	$sql = "SELECT Q1.MaHang, Q1.TenHang, Q1.DVT, Q1.NhaCC, Sum(Q1.SLTon) AS TongSLTon 
					FROM (
						SELECT hanghoa.MaHang, hanghoa.TenHang,hanghoa.DVT,hanghoa.NhaCC, nhapkho_ct.SLNhap as SLTon, nhapkho.NgayNhap FROM (hanghoa INNER JOIN nhapkho_ct ON hanghoa.MaHang = nhapkho_ct.MaHang) INNER JOIN nhapkho ON nhapkho_ct.SoPhieuN = nhapkho.SoPhieuN WHERE nhapkho.NgayNhap <= CURRENT_DATE 
						union all
						SELECT hanghoa.MaHang, hanghoa.TenHang,hanghoa.DVT,hanghoa.NhaCC, (-1)*xuatkho_ct.SLXuat as SLTon, xuatkho.NgayXuat FROM hanghoa INNER JOIN (xuatkho INNER JOIN xuatkho_ct ON xuatkho.SoPhieuX = xuatkho_ct.SoPhieuX) ON hanghoa.MaHang = xuatkho_ct.MaHang WHERE xuatkho.NgayXuat<= CURRENT_DATE ) AS Q1
					GROUP BY Q1.MaHang, Q1.TenHang, Q1.DVT, Q1.NhaCC;";
	//$sql = "SELECT * from hanghoa";
	$stmt = $dbh->query($sql);
	if ($stmt->num_rows > 0) {
		$delimiter = ",";
		$filename = "在庫数" . date('Y-m-d') . ".csv";
		//create a file pointer
		$f = fopen('php://memory', 'w');
		//set column header
		$fields = array('商品ID','単位','商品名','現在在庫数');
		//$fields = array('商品ID','商品名');
		fputcsv($f, $fields, $delimiter);
		while($row = $stmt->fetch_assoc()){
			$lineData = array($row["MaHang"],$row["DVT"],$row["TenHang"],$row["TongSLTon"]);
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
	}
	exit();
}
else{
			include '../login-bg.html';
			print'ログインしてください。<a href="../login/ログイン/login.php">ログイン</a><br/>';
			exit();
       }

 ?>