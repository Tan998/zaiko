<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
 
<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_admin()){
    echo "<script>alert('この機能はアクセスできません。');"."window.location = '".create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard'))."';</script>";
    /*header('Location: ' . create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard')));
    exit;*/
}
?>
 
<?php 
require_once('database/zaikosuu_db.php');
// Biến chứa lỗi
$error = array();
$error2 = array();
$error4 = array();
$item_code = isset($_GET['item_code']) ? $_GET['item_code'] : "" ;

//lay thong tin item
$sql = "SELECT hanghoa.TenHang,hanghoa.MaHang,hanghoa_ct.note, hanghoa_ct.bin_code, hanghoa_ct.hokanbasho,hanghoa_ct.joutai, qr_tb.data_url, hanghoa_img.img_base64 FROM hanghoa INNER JOIN hanghoa_ct ON hanghoa.bin_code = hanghoa_ct.bin_code INNER JOIN qr_tb ON hanghoa_ct.bin_code = qr_tb.MaHang INNER JOIN hanghoa_img ON hanghoa_ct.bin_code = hanghoa_img.bin_code WHERE hanghoa.bin_code = '$item_code';";
$item_data = db_get_list($sql);

//echo $item_code;
// Nếu người dùng submit form
if (is_submit('add_qr'))
{   
    $item_code = isset($_GET['item_code']) ? $_GET['item_code'] : "" ;
    // Lấy danh sách dữ liệu từ form
    $data = array(
    'TenHang'  => input_post('itemname'),
    'bin_code'     => input_post('bin_code'),
    'MaHang'     => input_post('bin_code'),
    );
    $data2 = array(
    'bin_code'     => input_post('bin_code'),
    'hokanbasho'  => input_post('hokanbasho'),
    'joutai'     => input_post('joutai'),
    'note'  => input_post('note'),
    'create_date'  => date('Y/m/d H:i:s'),
    );
    $data3 = array(
    'MaHang'  => input_post('bin_code'),
    'bin_code'  => input_post('bin_code'),
    'data_url'     => input_post('qr_img_data'),
    );
    $data4 = array(
    'bin_code'  => input_post('bin_code'),
    'img_base64'     => input_post('img_base64'),
    );
    // require file xử lý database cho user
    require_once('database/item_detail.php');
    
    
    date_default_timezone_set('Asia/Tokyo');

     
    // Thực hiện validate
    //
    if (input_post('bin_code_check') != input_post('bin_code')) {
        $error = db_edit_item_validate($data2);
        $error2 = db_edit_item_validate($data);
        $error4 = db_edit_item_validate($data4);
    }
    else{
        $error = db_edit_item_validate_coban($data2);
        $error2 = db_edit_item_validate_coban($data);
        $error4 = db_edit_item_validate_coban($data4);
    }
    // Nếu validate không có lỗi
    if (!$error && !$error2 && !$error4)
    {
        // Nếu insert thành công thì thông báo
        // và chuyển hướng về trang danh sách qr\\++|| 
        if (db_update_QR('hanghoa', $data, $item_code) && db_update_QR('hanghoa_ct', $data2,$item_code)){ 
            if(db_update_QR('qr_tb', $data3,$item_code) && db_update_QR('hanghoa_img', $data4,$item_code)){

        
            ?>
            <script language="javascript">
                alert('<?php echo input_post('itemname'); ?>の情報更新しました。!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard')); ?>';
            </script>
            <?php
            die();
            }
        }
    }
}
?>
 
<?php include_once('widgets/header.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
            integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/script.js" defer></script>
<!--<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>-->

<script src="./js/html5-qrcode.js" type="text/javascript"></script>

<!--
<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
-->
        <style>
            #spinner {
                display: none;
            }
            input[name="image-input"] ,input[id="qr-input-file"]{
                display: none;
            }
            .file_img_upload {
                display: inline-block;
                cursor: pointer;
            }
                    </style>
<h1>情報の編集</h1>
<div class="container">
    <nav class="mt-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'dashboard')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'qrcode_manager')); ?>">コード一覧</a></li>
        <li class="breadcrumb-item active" aria-current="page">商品情報の編集</li>
      </ol>
    </nav>
    <div class="controls row">
        <div class="col-1 col-md-2"></div>
        <div class="col-10 col-md-8 shadow p-3 mb-5 bg-body rounded">
        <?php foreach ($item_data as $item){ ?>
            <form id="main-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'edit_qr', 'item_code' => $item_code)); ?>">
                <div class="mb-3">
                    <label for="input-name" class="form-label">物品名</label>
                    <span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
                    <input required type="text" class="form-control" id="input-name" placeholder="物品名を入力" name="itemname" value="<?php echo $item['TenHang'] ;input_post('itemname'); ?>" />
                    <?php show_error($error2, 'itemname'); ?>
                </div>
                <div class="mb-3">
                    <label for="hokanbasho" class="form-label">保管場所</label>
                    <span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
                    <input required type="hokanbasho" class="form-control" id="hokanbasho" placeholder="保管場所を入力" name="hokanbasho" value="<?php echo $item['hokanbasho']; input_post('hokanbasho'); ?>" />
                    <?php show_error($error, 'hokanbasho'); ?>
                </div>
                <div class="mb-3">
                    <label for="joutai" class="form-label">状態</label>
                    <span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
                    <input required type="joutai" class="form-control" id="joutai" placeholder="状態を入力" name="joutai" value="<?php echo $item['joutai'] ;input_post('joutai'); ?>" />
                    <?php show_error($error, 'joutai'); ?>
                </div>
                <div class="mb-3">
                    <label for="zaikosuu" class="form-label">在庫数</label>
                    <input disabled type="text" class="form-control" id="zaikosuu" placeholder="在庫数を入力" name="zaikosuu" value="<?php $zaikosuu = db_get_row_zaikosuu($item['bin_code']); if($zaikosuu){echo $zaikosuu['TongSLTon'];}else{echo "0";};input_post('zaikosuu'); ?>">
                    <?php ////show_error($error, 'zaikosuu'); ?>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">備考</label>
                    <input type="text" class="form-control" id="note" placeholder="備考を入力" name="note" value="<?php echo $item['note'] ;input_post('note'); ?>">
                    <?php ////show_error($error, 'note'); ?>
                </div>
                <div>
                    <input hidden type="text" class="form-control" id="qr_img_data" name="qr_img_data" type="text"/>
                </div>
                <div class="mb-3">
                    <label for="bin_code_val" class="form-label">QRコード・バーコードの値</label>
                    <span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
                    <input required type="text" hidden name="bin_code_check" value="<?php echo $item['bin_code']; input_post('bin_code_check'); ?>">
                    <input required type="text" class="form-control" id="bin_code_val" name="bin_code" value="<?php echo $item['bin_code'];?>">
                    <?php show_error($error, 'bin_code'); ?>
                    <!--scan cam-->
                    <div class="col-12 mb-3">
                        <p><small class="text-muted"><i class="bi bi-camera"></i>未入力の場合は自動的に値が割り振られます。</small></p>
                        <a role="button" id="btn-scan-qr" class="btn btn-outline-dark border border-5 rounded border-dark">
                            <div class="">
                                <i class="fs-4 bi bi-qr-code-scan"></i>
                            </div>
                        </a>
                        or
                        <div id="reader" style="display: none;"></div>
                        <label for="qr-input-file" class="file_img_upload text-center shadow-sm bg-light rounded">
                            <a role="button" class="btn btn-outline-dark border border-5 rounded border-dark">
                                <div class="">
                                    <i class="fs-4 bi bi-file-earmark-image"></i>
                                </div>
                            </a>
                        </label>
                        <input class="input_file form-control form-control-sm" type="file" name="qr-input-file" id="qr-input-file" accept="image/*">
                        <script src="js/input_code.js"></script>
                    </div>
                    <div class="col-lg-6 row" id="scanner_box">
                        <div id="qr-reader" width="100%"></div>
                        <span id="qr-reader-results"></span>
                    </div>
                    <script src="js/qrCodeScanner.js"></script>
                    <!--scan cam-->
                    <!-- Spinner -->
                    <div class="d-flex justify-content-center align-items-center">
                        <div id="spinner" class="spinner-border text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <?php //show_error($error, 'bin_code'); ?>
                </div>
                <!--input image -->
                <div class="mb-3">
                    <label class="form-label">写真</label>
                    <div class="col-sm-8 col-md-6 d-flex align-items-end" id="file_img_upload">
                        <label for="image-input" class="file_img_upload text-center shadow-sm bg-light rounded">
                            <div class="btn ">
                                <i class="fs-3 bi bi-camera"></i><br>
                                <p class="card-text">商品画像</p>
                            </div>
                            <div class="card border-0 text-center">
                                <div class="card-body">
                                    <img class="card-img-top" id="preview" src="<?php echo $item['img_base64'];?>"></img>
                                </div>
                            </div>
                        </label>
                        <input class="input_file form-control form-control-sm" type="file" id="image-input" name="image-input" accept="image/*">
                    </div>
                    <input hidden type="text" id="img_base64" name="img_base64" value="<?php echo $item['img_base64'];?>">
                </div>
                <!--input image -->
                <div class="mb-3">
                    <a class="btn btn-success" onclick="$('#main-form').submit()" href="#">保存</a>
                    <input type="hidden" name="request_name" value="add_qr"/>
                    <a class="btn btn-secondary" href="<?php echo create_link(base_url('admin'), array('m' => 'action_qr_mana', 'a' => 'qrcode_manager')); ?>">戻る</a>
                </div>
            </form>
        <?php } ?>
        </div>
        <div class="col-md-2 col-1"></div>
        <div class="col-md-8">
            
        </div>
    </div>
</div>


 
<?php include_once('widgets/footer.php'); ?>