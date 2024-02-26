<?php if (!defined('IN_SITE')) die ('The request not found');

    ?>
    <?php
    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
      echo "<script>alert('この機能はアクセスできません。');"."window.location = '".create_link(base_url('admin'), array('m' => 'common', 'a' => 'dashboard'))."';</script>";
    }
    ?>
    <?php include_once('widgets/header.php'); 
    include_once('./database/zaikosuu_db.php');
    $error = array();
  if (is_submit('taraoroshi'))
  {   
    date_default_timezone_set('Asia/Tokyo');
    //
    $data = array(
    'bin_code'     => input_post('bin_code_val'),
    'SL_saucheck'  => input_post('fix_after_number'),
    'SL_truoccheck'  => input_post('fix_before_number'),
    'acc_action' => get_current_username(),
    'check_date'  => date("Y-m-d H:i:s"),
    'note' => input_post('note')
    );
    // require file xử lý database cho user
    require_once('database/check_inventory_db.php');
     
    // Thực hiện validate
    $error = db_check_inventory_validate($data);
      if (!$error) {
        if (db_insert('checkkho_ct', $data)){ 
          ?>
          <script language="javascript">
            alert('棚卸完了しました。!');
            window.location = '<?php echo create_link(base_url('admin'), array('m' => 'check_inventory', 'a' => 'inventory_history')); ?>';
          </script>
          <?php
          die();
        }
      }
}
?>
    <head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
            integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
          <script src="js/script.js" defer></script>
          <!--<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>-->

          <script src="./js/html5-qrcode.js" type="text/javascript"></script>
    </head>
    <style>
      body {
        margin-bottom: 95px;
      }
    </style>

<body>
<h1>棚卸</h1>
<div class="container mb-3">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'dashboard')); ?>">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">棚卸</li>
    </ol>
  </nav>
  <div class="">
    <div class="text-end mb-2"><a class="btn btn-primary" href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'check_inventory', 'a' => 'inventory_history')); ?>">棚卸履歴</a></div>
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
    </div>
  </div>
</div>

<div class="container card my-2 mb-5">
  <form id="myform" class="my-3 row" action="" method="POST">
    <label for="bin_code_val" class="form-label mb-2">商品番号　</label>
    <div class="col-sm-6">
      <!-- serch -->
      <div class="input-group mb-3">
        <input type="text" name="bin_code_val" id="bin_code_val" class="form-control" placeholder="商品番号を入力" aria-label="" aria-describedby="button-addon2">
        <input class="btn btn-dark" type="submit" id="button-addon2" name="add_item_submit" value="検索">
      </div>
    </div>
    <!-- Spinner -->
      <div class="d-flex justify-content-center align-items-center">
      <div id="spinner" class="spinner-border text-warning" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </form>
  <?php show_error($error, 'fix_before_number');?>
  <?php show_error($error, 'fix_after_number');?>
  <?php show_error($error, 'note');?>
<?php 
if (isset($_POST['add_item_submit'])) {
  $bin_code_val = isset($_POST['bin_code_val']) ? $_POST['bin_code_val'] : "" ;

  $zaikosuu = db_get_row_zaikosuu($bin_code_val);
  if ($bin_code_val != "") {
    $sql = "SELECT * FROM hanghoa WHERE hanghoa.bin_code = '$bin_code_val' ";
      $item_data = db_get_list($sql);
      if (count($item_data) > 0) { 
        echo "
        <div class='rounded border border-3 p-2'>
          <strong>商品名：".$item_data['0']['TenHang']."</strong><br><strong>商品番号：".$bin_code_val."</strong><br>
              <p class='text-danger'>※ご注意：棚卸は棚卸実施後、棚卸した数量に即座にデータが反映されます。</p>
              ";
        ?>
        <form id="myform1" method="POST" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'check_inventory', 'a' => 'inventory_home')); ?>"
          onsubmit="confirm('実行します。よろしいですか？');">
          <div class="container-fruid d-flex justify-content-center">
            <div class="col-12 d-flex justify-content-between row">
              <p class="bg-light bg-gradient border rounded-pill text-center my-2 p-1">在庫数: 　<u><strong><span id="zaikosuu"></span></strong></u></p>
              <input class="col-5 my-2 disabled" type="number" min="0" max="999" required value="<?php if($zaikosuu){echo $zaikosuu['TongSLTon'];} else {echo "0";}?>" class="form-control" disabled>
              <input hidden type="number" id="fix_before_number" name="fix_before_number" value="<?php if($zaikosuu){echo $zaikosuu['TongSLTon'];} else {echo "0";}?>">
              <span class="col-1 my-2 d-flex justify-content-center align-items-center"><strong>→</strong></span>
              <input hidden type="text" name="bin_code_val" value="<?php echo $bin_code_val; ?>">

              <input class="col-5 my-2" type="number" min="0" max="999" required name="fix_after_number" placeholder=""  class="form-control" id="fix_after_number" value="">
              <div class="p-0">
                <label for="note" class="form-label">理由</label>
                <span class="badge rounded-pill bg-danger" style="font-size: 10px;">必須</span>
                <textarea name="note" class="form-control" placeholder="理由をご入力してください。"><?php input_post('note'); ?></textarea>         
              </div>
              <div class="text-end">
                <a class="btn btn-success my-2" onclick="$('#myform1').submit()" href="#">棚卸</a>
                <input type="hidden" name="request_name" value="taraoroshi">
              </div>
            </div>
          </div>
      </form>
<?php   echo "</div>";}
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
<script>
  
</script>
  <div class="text-end mt-5 mb-2">
    <br>
    <a class="btn btn-secondary" onclick="javascript:(function() {window.location.href = window.location.href; })()">ページを更新</a>
  </div>
  <script>
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

</div>

<?php include_once('widgets/footer.php'); ?>