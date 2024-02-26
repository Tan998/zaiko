<?php if (!defined('IN_SITE')) die ('The request not found');

    ?>
    <?php
    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
    ?>
    <?php include_once('widgets/header.php'); 
      include_once('./database/zaikosuu_db.php');
    ?>
 
    <?php
    $sql = "SELECT * FROM checkkho_ct ORDER BY id desc";
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
    </head>
    <style>
      body {
        margin-bottom: 95px;
      }
    </style>

<body>
<h1>棚卸履歴</h1>
<div class="container-fluid">
  <nav class="mt-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'dashboard')); ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'check_inventory', 'a' => 'inventory_home')); ?>">棚卸</a></li>
      <li class="breadcrumb-item active" aria-current="page">棚卸履歴</li>
    </ol>
  </nav>
<div class="container-fluid mb-5 bg-light">
            <div class="col-sm-12 bg-light">
                <table class="table table-light table-striped table-bordered" id="my_table">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">棚卸ID</th>
                            <th scope="col">商品番号</th>
                            <th scope="col">棚卸前</th>
                            <th></th>
                            <th scope="col">棚卸後</th>
                            <th scope="col">担当者</th>
                            <th scope="col">棚卸の日付</th>
                            <th scope="col">メモ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php // VỊ TRÍ 02: CODE HIỂN THỊ NGƯỜI DÙNG ?>
                        <?php foreach ($item_data as $item){ 
                          ?>
                        <tr class="text-center">
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['bin_code']; ?></td>
                            <td><?php echo $item['SL_truoccheck']; ?></td>
                            <td><strong>→</strong></td>
                            <td><?php echo $item['SL_saucheck']; ?></td>
                            <td><?php echo $item['acc_action']; ?></td>
                            <td><?php echo $item['check_date']; ?></td>
                            <td><?php echo $item['note']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
  <script>/*
    new DataTable('#my_table', {
        order: [0],
        responsive: true,
    });*/
  </script>
</div>

<?php include_once('widgets/footer.php'); ?>