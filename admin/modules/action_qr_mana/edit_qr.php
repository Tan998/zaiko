<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
 
<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_admin()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
?>
 
<?php 
// Biến chứa lỗi
$error = array();
$item_code = isset($_GET['item_code']) ? $_GET['item_code'] : "" ;

//lay thong tin item
$sql = "SELECT hanghoa.TenHang,hanghoa.MaHang,hanghoa_ct.note, hanghoa_ct.bin_code, hanghoa_ct.hokanbasho,hanghoa_ct.joutai, qr_tb.data_url FROM hanghoa INNER JOIN hanghoa_ct ON hanghoa.bin_code = hanghoa_ct.bin_code INNER JOIN qr_tb ON hanghoa_ct.bin_code = qr_tb.MaHang WHERE hanghoa.bin_code = '$item_code';";
$item_data = db_get_list($sql);

echo $item_code;
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
    // require file xử lý database cho user
    require_once('database/item_detail.php');
     
    // Thực hiện validate
    //$error = db_item_validate($data);
    //$error = db_item_validate($data2);
    date_default_timezone_set('Asia/Tokyo');

     
    
    // Nếu validate không có lỗi
    if ($item_code != "")
    {
        // Nếu insert thành công thì thông báo
        // và chuyển hướng về trang danh sách qr\\++|| 
        if (db_update_QR('hanghoa', $data, $item_code) && db_update_QR('hanghoa_ct', $data2,$item_code)){ 
            if(db_update_QR('qr_tb', $data3,$item_code)){

        
            ?>
            <script language="javascript">
                alert('edited!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'action_qr_mana', 'a' => 'qrcode_manager')); ?>';
            </script>
            <?php
            die();
            }
        }
        else {
        echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => '404'));
        }
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
<h1>Edit</h1>
<div class="container">
    <div class="controls row">
        <div class="col-1 col-md-2"></div>
        <div class="col-10 col-md-8 shadow p-3 mb-5 bg-body rounded">
        <?php foreach ($item_data as $item){ ?>
            <form id="main-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'edit_qr', 'item_code' => $item_code)); ?>">
                <div class="mb-3">
                    <label for="input-name" class="form-label">物品名</label>
                    <input required type="text" class="form-control" id="input-name" placeholder="物品名を入力" name="itemname" value="<?php echo $item['TenHang'] ;input_post('itemname'); ?>" />
                    <?php //show_error($error, 'itemname'); ?>
                </div>
                <div class="mb-3">
                    <label for="hokanbasho" class="form-label">保管場所</label>
                    <input required type="hokanbasho" class="form-control" id="hokanbasho" placeholder="保管場所を入力" name="hokanbasho" value="<?php echo $item['hokanbasho']; input_post('hokanbasho'); ?>" />
                    <?php //show_error($error, 'hokanbasho'); ?>
                </div>
                <div class="mb-3">
                    <label for="joutai" class="form-label">状態</label>
                    <input required type="joutai" class="form-control" id="joutai" placeholder="状態を入力" name="joutai" value="<?php echo $item['joutai'] ;input_post('joutai'); ?>" />
                    <?php //show_error($error, 'joutai'); ?>
                </div>
                <div class="mb-3">
                    <label for="zaikosuu" class="form-label">在庫数</label>
                    <input disabled type="text" class="form-control" id="zaikosuu" placeholder="在庫数を入力" name="zaikosuu" value="0 <?php //echo input_post('zaikosuu'); ?>">
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
                    <label for="bin_code" class="form-label">QRコード・バーコードの値</label>
                    <input required type="text" class="form-control" id="code_value" name="bin_code" value="<?php echo $item['bin_code']; input_post('bin_code'); ?>">
                    <p><small class="text-muted">QRコードの値と画像を持っているの場合は値を入力してください。</small></p>
                    <!--scanner
                    <a id="btn-scan-qr"><img style="width: 100px;" src="https://icon-library.com/images/scan-qr-code-icon/scan-qr-code-icon-4.jpg"></a>
                    -->
                          <div class="cv-bf">
                            <canvas hidden="" id="qr-canvas"></canvas>
                          </div>
                          <div id="qr-result" hidden=""></div>
                          <!--script
                          <script src="js/qrCodeScanner.js"></script>
                          -->
                        <div class="add_file_area">
                          <div id="reader" style="display: none;"></div>
                          <input class="input_file form-control form-control-sm" type="file" id="qr-input-file"  onchange="imageUploaded()" accept="image/*">
                          <script src="js/input_code.js"></script>
                        </div>
                    <?php //show_error($error, 'bin_code'); ?>
                </div>
                <div class="mb-3">
                    <p class=""><small class="text-muted">または、新規QRコード登録を作成します</small><strong>→</strong>
                    <!--show/hide button-->
                    <input class="btn btn-warning" type="button" id="toggler" onClick="showhide();" />
                    <!--show/hide button-->
                    </p>
                </div>
                <div class="mb-3">
                    <a class="btn btn-success" onclick="$('#main-form').submit()" href="#">Save</a>
                    <input type="hidden" name="request_name" value="add_qr"/>
                    <a class="btn btn-secondary" href="<?php echo create_link(base_url('admin'), array('m' => 'action_qr_mana', 'a' => 'qrcode_manager')); ?>">戻る</a>
                </div>
            </form>
        <?php } ?>
            <section id="togglee" style="visibility: hidden;">
                <div> 
                    <div>
                        <form id="generate-form" class="mt-4">
                            <input id="bin_code" class="form-control" type="text" placeholder="QRコードの値を入力" />

                            <select name="size" id="size" class="form-select form-select-sm">
                                <option value="189.9" selected>5(cm)x5(cm)</option>
                                <option value="75.6">2(cm)x2(cm)</option>
                                <option value="113.4">3(cm)x3(cm)</option>
                                <option value="151.2">4(cm)x4(cm)</option>
                                
                            </select>
                            <button type="submit" class="btn btn-outline-primary my-1">
                                QRコードを作成
                            </button>
                        </form>
                    </div>
                </div>

                <div id="generated">
                    <!-- Spinner -->
                    <div id="spinner" class="spinner-border" role="status" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div id="qrcode" class="m-auto my-3 "></div>
                </div>
            </section>
        </div>
        <div class="col-md-2 col-1"></div>
        <div class="col-md-8">
            
        </div>
    </div>
</div>


 
<?php include_once('widgets/footer.php'); ?>