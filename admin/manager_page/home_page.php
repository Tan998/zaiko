<?php if (!defined('IN_SITE')) die ('The request not found');

    ?>
<!doctype html>
<html lang="jp">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			.card {
				display: flex;
				align-items: center;
			}
			.drop-style {
				display: flex;
    			justify-content: center;
    			margin-bottom: 95px;
			}
			.dropdown-menu li {
				display: flex;
				align-items: center;
				justify-content: center;
			}
			.bi-qr-code-scan::after {
				content: "管理⚙️";
				display:contents; 
			    position:absolute; 
			    background:url(''); 
			    z-index:1; 
			    top:1;
			    font-size: 15px;
			}
		</style>
	</head>
	<body>
		<div class="container-fruid mt-3">
			<div class="row">
				<div class="col-sm-2 col-lg-3"></div>
				<div class="col-12 col-sm-8 col-lg-6 row">
					<div class="col-6 col-sm-6 my-2">
						<a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'add_item', 'a' => 'add_item')); ?>">
							<div class="card rounded-9 text-center">
							  <i class="bi bi-download" style="font-size: 53.34px;"></i>
							    <p class="card-text">入庫</p>
							</div>
						</a>
					</div>
					<div class="col-6 col-sm-6 my-2">
						<a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'remove_item', 'a' => 'remove_item')); ?>">
							<div class="card rounded-9 text-center">
							  <i class="bi bi-upload" style="font-size: 53.34px;"></i>
							    <p class="card-text">出庫</p>
							</div>
						</a>
					</div>
					<div class="col-6 col-sm-6 my-2">
						<a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'scan_search', 'a' => 'scan_search')); ?>">
							<div class="card rounded-9 text-center">
							  <i class="bi bi-search" style="font-size: 53.34px;"></i>
							    <p class="card-text">スキャン検索</p>
							</div>
						</a>
					</div>
					<?php if (is_admin()){ ?>
					<div class="col-6 col-sm-6 my-2">
						<a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'add_qr')); ?>">
							<div class="card rounded-9 text-center">
							  <i class="bi bi-plus-circle" style="font-size: 53.34px;"></i>
							    <p class="card-text">新規登録</p>
							</div>
						</a>
					</div>
					<div class="col-6 col-sm-6 my-2">
						<a href="<?php echo create_link(base_url('admin'), array('m' => 'action_qr_mana', 'a' => 'qrcode_manager')); ?>">
							<div class="card rounded-9 text-center">
							  <i class="bi bi-qr-code-scan" style="font-size: 53.34px;"></i>
							    <p class="card-text">コード管理</p>
							</div>
						</a>
					</div>
					<div class="col-6 col-sm-6 my-2">
						<a href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>">
							<div class="card rounded-9 text-center">
							  <i class="bi bi-person-gear" style="font-size: 53.34px;"></i>
							    <p class="card-text">ユーザー管理</p>
							</div>
						</a>
					</div>
					<div class="col-6 col-sm-6 my-2">
						<a href="<?php echo create_link(base_url('admin'), array('m' => 'check_inventory', 'a' => 'inventory_home')); ?>" style="padding:0;">
							<div class="card rounded-9 text-center">
							  <i class="bi bi-journal-bookmark-fill" style="font-size: 53.34px;"></i>
							    <p class="card-text">棚卸</p>
							</div>
						</a>
					</div>
					<div class="col-6 col-sm-6 my-2">
						<a  href="<?php echo create_link(base_url('admin'), array('m' => 'csv', 'a' => 'csv_homepage')); ?>" style="padding:0;">
							<div class="card rounded-9 text-center">
							  <i class="bi bi-filetype-csv" style="font-size: 53.34px;"></i>
							    <p class="card-text">CSVエクスポート</p>
							</div>
						</a>
					</div>
					<?php } ?>
				</div>
				<div class="col-sm-2 col-lg-3"></div>
			</div>
			<!-- Default dropup button -->
			<div class="drop-style sticky-top">
				<div class="btn-group dropup-center dropup">
					<button type="button" class="btn btn-light shadow-sm dropdown-toggle rounded-pill" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 120px;">
					    MENU
					  </button>
					  <ul class="dropdown-menu">
					    <!-- Dropdown menu links -->
					    <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i>　　設定</a></li>
					    <li><hr class="dropdown-divider"></li>
					    <li><a class="dropdown-item" href="#"><i class="bi bi-info-circle"></i>　　情報</a></li>
					    <li><hr class="dropdown-divider"></li>
					    <li><a class="dropdown-item" onclick="return confirm('ログアウトしますか？')" href="<?php echo base_url('admin/?m=common&a=logout'); ?>"><i class="bi bi-door-open"></i>　　ログアウト</a></li>
					  </ul>
				</div>
			</div>
			<!-- Default dropup button -->
		</div>
	</body>
</html>