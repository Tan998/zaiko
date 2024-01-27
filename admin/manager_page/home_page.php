<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			a {
				color: #313131;
				text-decoration: none;
			}
			.card {
				display: flex;
				align-items: center;
			}
			.card img {
				width: 80px;
				height: 80px;
				padding: 5px;
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
			.rounded-9 {
				border-radius: .9rem!important;
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
		<div class="container-fruid">
			<div class="row">
				<div class="col-sm-2 col-lg-3"></div>
				<div class="col-12 col-sm-8 col-lg-6 row">
					<div class="col-6 col-sm-6 my-2">
						<a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'add_item', 'a' => 'add_item')); ?>">
							<div class="card rounded-9 text-center">
							  <img src="./img/add.png" class="card-img-top" alt="...">
							    <p class="card-text">入庫</p>
							</div>
						</a>
					</div>
					<div class="col-6 col-sm-6 my-2">
						<a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'remove_item', 'a' => 'remove_item')); ?>">
							<div class="card rounded-9 text-center">
							  <img src="./img/share.png" class="card-img-top" alt="...">
							    <p class="card-text">出庫</p>
							</div>
						</a>
					</div>
					<?php if (is_admin()){ ?>
					<div class="col-6 col-sm-6 my-2">
						<a href="">
							<div class="card rounded-9 text-center">
							  <img src="./img/list-check.png" class="card-img-top" alt="...">
							    <p class="card-text">棚卸</p>
							</div>
						</a>
					</div>
					<div class="col-6 col-sm-6 my-2">
						<a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'action_qr_mana', 'a' => 'add_qr')); ?>">
							<div class="card rounded-9 text-center">
							  <img src="./img/plus.jpg" class="card-img-top" alt="...">
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
					
					<?php } ?>
					<div class="col-6 col-sm-6 my-2">
						<a href="">
							<div class="card rounded-9 text-center">
							  <img src="./img/scan.jpg" class="card-img-top" alt="...">
							    <p class="card-text">スキャン検索</p>
							</div>
						</a>
					</div>
				</div>
				<div class="col-sm-2 col-lg-3"></div>
			</div>
			<!-- Default dropup button -->
			<div class="drop-style fixed-bottom">
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
					    <li><a class="dropdown-item" onclick="return confirm('Are you sure ?')" href="<?php echo base_url('admin/?m=common&a=logout'); ?>"><i class="bi bi-door-open"></i>　　ログアウト</a></li>
					  </ul>
				</div>
			</div>
			<!-- Default dropup button -->
		</div>
	</body>
</html>