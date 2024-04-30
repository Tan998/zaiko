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
    $sql = "SELECT hanghoa.TenHang,hanghoa.MaHang,hanghoa_ct.note, hanghoa_ct.bin_code, qr_tb.data_url FROM hanghoa INNER JOIN hanghoa_ct ON hanghoa.bin_code = hanghoa_ct.bin_code INNER JOIN qr_tb ON hanghoa_ct.bin_code = qr_tb.MaHang ORDER BY hanghoa.id desc;";
    $item_data = db_get_list($sql);

?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.4.1/css/rowGroup.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/rowgroup/1.4.1/js/dataTables.rowGroup.min.js"></script>
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
  <h1>コード管理</h1>
  <div class="container">
    <nav class="mt-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'dashboard')); ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">コード一覧</li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-12 my-3">
          <div class="col-sm-6 mb-3 text-start btn-group"  role="group">
            <a class="shadow-sm btn btn-outline-success" href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'add_qr')); ?>">新規登録</a>
            <a class="shadow-sm btn btn-outline-success disabled" href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => '404')); ?>">新しいQRを発行</a>
            <a class="shadow-sm btn btn-outline-secondary" href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'csv', 'a' => 'export_action/export_QRlist')); ?>" onclick="return confirm('Export to CSV')">CSV</a>
          </div>
          <div class="col-12">
            <section class="btn-group" role="group">
                <input name="QRorBarcode" id="phoneInput" class="btn-check" value="QR_show" type="radio" autocomplete="off" checked>
                <label class="btn btn-outline-primary" gumby-trigger="#QR_show" for="phoneInput">QR</label>

                <input name="QRorBarcode" id="webInput" class="btn-check" value="barcode_show" type="radio" autocomplete="off">
                <label class="btn btn-outline-primary" gumby-trigger="#barcode_show" for="webInput">Barcode</label>
            </section>
          </div>
      </div>
      <div class="col-12 bg-light">
          <table class="table table-hover table-light" id="my_table3">
            <thead>
              <tr>
                <th>コード情報</th>
                <th>商品番号</th>
                <th class="">在庫数</th>
                <th>備考</th>
                <?php if (is_supper_admin()){ ?>
                <th>アクション</th>
                <?php } ?>
                <th class=""></th>
              </tr>
            </thead>
            <tbody>
              <script>
                // Tao nut download QR
                var createSaveBtn = (savebin_code,stt) => {
                  var link = document.createElement('a');
                  link.id = 'save-link';
                  link.classList ='btn btn-sm btn-outline-info ms-1';
                  link.href = savebin_code;
                  link.download = 'qrcode'+stt;
                  link.innerHTML = '<i class="bi bi-download"></i>';
                  document.getElementById('qrcode'+stt).appendChild(link);
                };
                // Tao nut download barcode
                var createSaveBtn_bar = (savebin_code,stt) => {
                  var link = document.createElement('a');
                  link.id = 'save-link';
                  link.classList ='btn btn-sm btn-outline-info mt-2';
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
                        <!-- QR code -->
                        <?php $stt+=1; ?>
                        <div class="col-12 QR_show" id="QR_show">
                          <p class="text-break"><strong>商品名：</strong><?php echo $item['TenHang']; ?></p>
                          <div id="qrcode<?php echo $stt; ?>" class="d-flex align-items-end">
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
                          <p><strong>商品名：</strong><?php echo $item['TenHang']; ?></p>
                          <div id="barcode<?php echo $stt; ?>" class="d-flex align-items-start flex-column">
                            <canvas class="img-thumbnail" id="canvas_bar<?php echo $stt; ?>"></canvas>
                            <script>
                              JsBarcode("#canvas_bar<?php echo $stt; ?>", "<?php echo $item['bin_code']; ?>", {
                                format: "CODE128B",
                                width:1,
                                height:60
                              });
                              // Tao nut download
                                var href_bar = document.getElementById('canvas_bar<?php echo $stt; ?>').toDataURL()
                                createSaveBtn_bar(href_bar,<?php echo $stt; ?>);
                            </script>
                          </div>
                        </div>
                  </td>
                  <td class="align-middle"><?php echo $item['bin_code']; ?></td>
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
                <td class="align-middle"><?php echo $item['note']; ?></td>
                <?php if (is_supper_admin()){ ?>
                <td class="align-middle">
                  <div class="d-flex justify-content-around row">
                    <form method="POST" class="form-delete" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'delete_qr')); ?> " onsubmit="return confirm('この操作により、製品に関連するすべてのデータが削除されます。ご注意ください！');">
                        <a class="btn btn-outline-info fs-5 my-1" href="<?php echo create_link(base_url('admin'), array('m' => 'action_qr_mana', 'a' => 'edit_qr', 'item_code' => $item['bin_code'])); ?>"><i class="bi bi-pencil"></i></a>
                        <input type="hidden" name="redirect" value="<?php echo create_link(base_url('admin'), array('m' => 'action_qr_mana', 'a' => 'qrcode_manager')); ?>"/>
                        <input type="hidden" name="item_code" value="<?php echo $item['bin_code'];?>"/>
                        <input type="hidden" name="request_name" value="delete_qr"/>
                        <a href="#" class="btn-submit btn btn-outline-danger fs-5" onclick="$(this).parent().submit()"><i class="bi bi-trash"></i></a>
                    </form>
                  </div>
                </td>
                <?php } ?>
                <td class="align-middle">
                  <div class="">
                    <a href="<?php echo create_link(base_url('admin'), array('m' => 'item', 'a' => 'item_detail', 'item_code' => $item['bin_code'])); ?>"class="fs-5" ><i class="bi bi-info-circle"></i></a>      
                  </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
      </div>
    </div>
</div>

<script>
  /*//new DataTable('#my_table1');
  $(document).ready(function(){
    $('#my_table3').dataTable({
    'order' :[] })
  });*/
</script>
    
<script language="javascript">
/*$(document).ready(() =>{
  // Nếu người dùng click vào nút delete
  // Thì submit form
  //$('.btn-submit').click(function(){
  //$(this).parent().submit();
  //return false; });
               
  // Nếu sự kiện submit form xảy ra thì hỏi người dùng có chắc không?
  $('.form-delete').submit(function(){
   // if (!confirm('削除しますか?')){
   // return false;
    //}
  // Nếu người dùng chắc chắn muốn xóa thì ta thêm vào trong form delete
  // một input hidden có giá trị là URL hiện tại, mục đích là giúp ở 
  // trang delete sẽ lấy url này để chuyển hướng trở lại sau khi xóa xong
  $(this).append('<input type="hidden" name="redirect" value="'+window.location.href+'"/>');
                         
  // Thực hiện xóa
  return true;
  });
});*/
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