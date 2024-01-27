<?php if (!defined('IN_SITE')) die ('The request not found');

    ?>
    <?php
    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
    ?>
    <?php include_once('widgets/header.php'); ?>
 
    <?php
    $sql = "SELECT hanghoa.TenHang,hanghoa.MaHang,hanghoa_ct.note, hanghoa_ct.bin_code, qr_tb.data_url FROM hanghoa INNER JOIN hanghoa_ct ON hanghoa.bin_code = hanghoa_ct.bin_code INNER JOIN qr_tb ON hanghoa_ct.bin_code = qr_tb.MaHang;";
    $item_data = db_get_list($sql);

?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <script type="text/javascript" src="./js/jquery.qrcode.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    </head>
    <style>
      body {
        margin-bottom: 95px;
      }

      .show {
        display: block;
      }
      .hide {
        display: none;
      }
      
    </style>

<body>

  <div class="container">
    <div class="row">
      <div class="col-12 my-3 row">
          <div class="col-sm-6 mb-3 text-start">
            <a class="btn btn-success" href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'add_qr')); ?>">新規登録</a>
            <a class="btn btn-success" href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => '404')); ?>">新しいQRを発行</a>
            <a class="btn btn-secondary" href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'export_QRlist')); ?>" onclick="return confirm('Export to CSV')">CSV</a>
          </div>
          <section class="light">
            <div class="form-check">
              <label class="radio toggle form-check-label" gumby-trigger="#QR_show" for="phoneInput">
                <input name="QRorBarcode" id="phoneInput" class="form-check-input" value="QR_show" type="radio">
                <span class="design"></span>
                <span class="text">QR</span>
              </label>
            </div>
            <div class="form-check">
              <label class="radio toggle form-check-label" gumby-trigger="#barcode_show" for="webInput">
                <input name="QRorBarcode" id="webInput" class="form-check-input" value="barcode_show" type="radio">
                <span class="design"></span>
                <span class="text">Barcode</span>
              </label>
            </div>
          </section>
      </div>
      <div class="col-12">
          <table class="table table-hover table-light" id="my_table3">
            <thead>
              <tr>
                <th>QRコード情報</th>
                <th class="">在庫数</th>
                <th class=""></th>
                <?php if (is_supper_admin()){ ?>
                <th></th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <script>
                // Tao nut download QR
                var createSaveBtn = (savebin_code,stt) => {
                  var link = document.createElement('a');
                  link.id = 'save-link';
                  link.classList ='btn btn-outline-info ms-2 mb-4';
                  link.href = savebin_code;
                  link.download = 'qrcode'+stt;
                  link.innerHTML = '<i class="bi bi-download"></i>';
                  document.getElementById('qrcode'+stt).appendChild(link);
                };
                // Tao nut download barcode
                var createSaveBtn_bar = (savebin_code,stt) => {
                  var link = document.createElement('a');
                  link.id = 'save-link';
                  link.classList ='btn btn-outline-info';
                  link.href = savebin_code;
                  link.download = 'barcode'+stt;
                  link.innerHTML = '<i class="bi bi-download"></i>';
                  document.getElementById('barcode'+stt).appendChild(link);
                };
              </script>
              <?php $stt = 0; ?>
              <?php 

              // include lấy thông tin số lượng tồn
              include_once('database/zaikosuu_db.php');

              foreach ($item_data as $item){ ?>
              <tr class="">
                <td class="title align-middle">
                  <div class="card" style="max-width: 720px;">
                    <div class="row g-0">
                      <div class="col-md-4 d-flex justify-content-center my-2 row">
                        <!-- QR code -->
                        <?php $stt+=1; ?>
                        <div class="col-12 QR_show" id="QR_show">
                          <div id="qrcode<?php echo $stt; ?>">
                            <script>
                              jQuery('#qrcode<?php echo $stt; ?>').qrcode({
                                id : 'canvas<?php echo $stt; ?>',
                                width : 100,
                                height : 100,
                                text  : "<?php echo $item['bin_code']; ?>"
                              });
                              // Tao nut download
                              var href = document.getElementById('canvas<?php echo $stt; ?>').toDataURL()
                              createSaveBtn(href,<?php echo $stt; ?>);
                            </script>
                          </div>
                        </div>
                        <!-- barcode -->
                        <div class="col-12 barcode_show hide" id="barcode_show" >
                          <div id="barcode<?php echo $stt; ?>">
                            <canvas class="img-thumbnail" id="canvas_bar<?php echo $stt; ?>"></canvas>
                            <script>
                              JsBarcode("#canvas_bar<?php echo $stt; ?>", "<?php echo $item['bin_code']; ?>", {
                                format: "code39",
                              });
                              // Tao nut download
                                var href_bar = document.getElementById('canvas_bar<?php echo $stt; ?>').toDataURL()
                                createSaveBtn_bar(href_bar,<?php echo $stt; ?>);
                            </script>
                          </div>
                        </div>
                        
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title"><?php echo $item['TenHang']; ?></h5>
                          <h6 class="card-subtitle mb-2 text-muted">値: <?php echo $item['bin_code']; ?></h6>
                          <p class="card-text"><small class="text-muted">備考: <?php echo $item['note']; ?>.</small></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <!--在庫数-->
                <td class="align-middle ">
                  <span><?php $zaikosuu = db_get_row_zaikosuu($item['bin_code']);
                              if (empty($zaikosuu)){
                                  echo '0';
                              }
                              // nếu có kết quả
                              else {echo $zaikosuu['TongSLTon'];}
                              ?>
                    </span><i class="bi bi-box-seam"></i>
                </td>
                <!--在庫数-->
                <?php if (is_supper_admin()){ ?>
                <td class="align-middle">
                  <div class="d-flex justify-content-around row">
                    <form method="POST" class="form-delete" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'delete_qr')); ?>">
                        <a class="btn btn-outline-info fs-5 my-1" href="<?php echo create_link(base_url('admin'), array('m' => 'action_qr_mana', 'a' => 'edit_qr', 'item_code' => $item['bin_code'])); ?>"><i class="bi bi-pencil"></i></a>
                        <input type="hidden" name="item_code" value="<?php echo $item['bin_code']; ?>"/>
                        <input type="hidden" name="request_name" value="delete_qr"/>
                        <a href="#" class="btn-submit btn btn-outline-danger fs-5"><i class="bi bi-trash"></i></a>
                    </form>            
                  </div>
                </td>
                <?php } ?>
                <?php if (is_admin()){ ?>
                <td class="align-middle">
                  <div class="d-flex justify-content-around row">      
                  </div>
                </td>
                <?php } ?>
              </tr>
              <?php } ?>
            </tbody>
          </table>
      </div>
    </div>
</div>

<script>
  //new DataTable('#my_table1');
  $(document).ready(function(){
    $('#my_table3').dataTable({
    'order' :[] })
  });
</script>
    
<script language="javascript">
$(document).ready(function(){
  // Nếu người dùng click vào nút delete
  // Thì submit form
  $('.btn-submit').click(function(){
  $(this).parent().submit();
  return false; });
               
  // Nếu sự kiện submit form xảy ra thì hỏi người dùng có chắc không?
  $('.form-delete').submit(function(){
    if (!confirm('削除しますか?')){
    return false;
    }
  // Nếu người dùng chắc chắn muốn xóa thì ta thêm vào trong form delete
  // một input hidden có giá trị là URL hiện tại, mục đích là giúp ở 
  // trang delete sẽ lấy url này để chuyển hướng trở lại sau khi xóa xong
  $(this).append('<input type="hidden" name="redirect" value="'+window.location.href+'"/>');
                         
  // Thực hiện xóa
  return true;
  });
});
</script>

      <script>
      $("input[name=QRorBarcode]:radio").click(function(ev) {
        if (ev.currentTarget.value == "QR_show") {
          $('.QR_show').addClass('show');
          $('.QR_show').removeClass('hide');
          $('.barcode_show').addClass('hide');
          $('.barcode_show').removeClass('show');
        } else if (ev.currentTarget.value == "barcode_show") {
          $('.QR_show').addClass('hide');
          $('.QR_show').removeClass('show');
          $('.barcode_show').addClass('show');
          $('.barcode_show').removeClass('hide');


        }
      });
    </script> 
<?php include_once('widgets/footer.php'); ?>