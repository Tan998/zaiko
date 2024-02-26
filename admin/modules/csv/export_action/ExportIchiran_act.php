<?php if (!defined('IN_SITE')) die ('The request not found');

    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
?>
<?php
	if (is_submit('CSV_download')){
		$sql="SELECT hanghoa.id,hanghoa.bin_code,hanghoa.TenHang,hanghoa_ct.hokanbasho,hanghoa_ct.joutai,hanghoa_ct.note FROM hanghoa INNER JOIN hanghoa_ct ON hanghoa.bin_code = hanghoa_ct.bin_code";
    	$result = db_get_list($sql);
    	include_once('./database/zaikosuu_db.php');
		if ($result) {
			$delimiter = ",";
			$filename = "在庫数一覧" . date('Y-m-d') . ".csv";
			//create a file pointer
			$f = fopen('php://memory', 'w');
			//set column header
			$fields = array('商品番号','商品名','保管場所','状態','メモ','在庫数');
			//$fields = array('商品ID','商品名');
			fputcsv($f, $fields, $delimiter);
			foreach ($result as $item){
				$zaikosuu = db_get_row_zaikosuu($item['bin_code']);
				if(!$zaikosuu){$zaikosuu["TongSLTon"] = "0";}
				$lineData = array($item["bin_code"],$item["TenHang"],$item["hokanbasho"],$item["joutai"],$item["note"],$zaikosuu["TongSLTon"]);
				//$lineData = array($item["MaHang"],$item["TenHang"]);
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
	}
 ?>