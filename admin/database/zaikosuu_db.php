<?php if (!defined('IN_SITE')) die ('The request not found');
 
function db_get_row_zaikosuu($bin_code){
    $sql = "SELECT Sum(Q1.SLTon) AS TongSLTon 
                    FROM (
                        SELECT hanghoa.id, hanghoa.MaHang, hanghoa.bin_code, hanghoa.TenHang,hanghoa.DVT,hanghoa.NhaCC, nhapkho_ct.SLNhap as SLTon, nhapkho.NgayNhap FROM (hanghoa INNER JOIN nhapkho_ct ON hanghoa.MaHang = nhapkho_ct.MaHang) INNER JOIN nhapkho ON nhapkho_ct.SoPhieuN = nhapkho.SoPhieuN WHERE nhapkho.NgayNhap <= '".date('Y/m/d')."'
                        union all
                        SELECT hanghoa.id, hanghoa.MaHang,hanghoa.bin_code, hanghoa.TenHang,hanghoa.DVT,hanghoa.NhaCC, (-1)*xuatkho_ct.SLXuat as SLTon, xuatkho.NgayXuat FROM hanghoa INNER JOIN (xuatkho INNER JOIN xuatkho_ct ON xuatkho.SoPhieuX = xuatkho_ct.SoPhieuX) ON hanghoa.MaHang = xuatkho_ct.MaHang WHERE xuatkho.NgayXuat<= '".date('Y/m/d')."'
                        union all
                        SELECT hanghoa.id, hanghoa.MaHang,hanghoa.bin_code, hanghoa.TenHang,hanghoa.DVT,hanghoa.NhaCC, (checkkho_ct.SL_saucheck - checkkho_ct.SL_truoccheck) as SLTon, checkkho_ct.check_date FROM hanghoa INNER JOIN checkkho_ct ON hanghoa.bin_code = checkkho_ct.bin_code) AS Q1 WHERE Q1.bin_code = '$bin_code' GROUP BY Q1.id;";
    return db_get_row($sql);
}

/*$sql = "SELECT Sum(Q1.SLTon) AS TongSLTon 
                    FROM (
                        SELECT hanghoa.id, hanghoa.MaHang, hanghoa.bin_code, hanghoa.TenHang,hanghoa.DVT,hanghoa.NhaCC, nhapkho_ct.SLNhap as SLTon, nhapkho.NgayNhap FROM (hanghoa INNER JOIN nhapkho_ct ON hanghoa.MaHang = nhapkho_ct.MaHang) INNER JOIN nhapkho ON nhapkho_ct.SoPhieuN = nhapkho.SoPhieuN WHERE nhapkho.NgayNhap <= CURRENT_DATE 
                        union all
                        SELECT hanghoa.id, hanghoa.MaHang,hanghoa.bin_code, hanghoa.TenHang,hanghoa.DVT,hanghoa.NhaCC, (-1)*xuatkho_ct.SLXuat as SLTon, xuatkho.NgayXuat FROM hanghoa INNER JOIN (xuatkho INNER JOIN xuatkho_ct ON xuatkho.SoPhieuX = xuatkho_ct.SoPhieuX) ON hanghoa.MaHang = xuatkho_ct.MaHang WHERE xuatkho.NgayXuat<= CURRENT_DATE ) AS Q1 WHERE Q1.bin_code = '$bin_code' GROUP BY Q1.id;";*/
?>