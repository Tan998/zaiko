<?php if (!defined('IN_SITE')) die ('The request not found');

    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
?>
<?php
if (is_submit('CSV_download') && input_post('year_month') != "") {
$year_month = input_post('year_month');
$first_day_this_month = date("{$year_month}-01");
$last_day_this_month  = date("{$year_month}-t");

$from_date = $first_day_this_month;
$to_date = date("Y-m-t", strtotime($first_day_this_month));
	if (strtotime($first_day_this_month) < strtotime($last_day_this_month)) {
		$sql = "SELECT hanghoa.id, hanghoa.bin_code,xuatkho_ct.STT,hanghoa.MaHang, hanghoa.TenHang, xuatkho_ct.SLXuat, xuatkho.NgayXuat,xuatkho_ct.update_time, xuatkho_ct.NguoiPhuTrach FROM hanghoa INNER JOIN (xuatkho INNER JOIN xuatkho_ct ON xuatkho.SoPhieuX = xuatkho_ct.SoPhieuX) ON hanghoa.MaHang = xuatkho_ct.MaHang WHERE xuatkho.NgayXuat BETWEEN '".$from_date."' AND '".$to_date."' order by xuatkho.NgayXuat,xuatkho_ct.STT";
    	$result = db_get_list($sql);
			if ($result) {
				$delimiter = ",";
				$filename = "搬出日" . $from_date  ."から". $to_date ."まで".".csv";
				//create a file pointer
				$f = fopen('php://memory', 'w');
				//set column header
				$fields = array('商品番号','商品名','出庫数量','出庫日','担当者','データ更新日');
				//$fields = array('商品ID','商品名');
				fputcsv($f, $fields, $delimiter);
				foreach ($result as $item){
					$lineData = array($item["MaHang"],$item["TenHang"],$item["SLXuat"],$item["NgayXuat"],$item["NguoiPhuTrach"],$item["update_time"]);
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
			else {header('location: '.create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'nodata_err')));}
	}
}
else {header('location: '.create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'nodata_err')));}
 ?>