<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
<?php 
if (!is_admin()){
	redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
include_once('widgets/header.php'); ?>

		<style>
			header {
				height: 80px;
			}
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
			.bi-download-style::after, .bi-upload-style::after, .bi-box-seam::after {
				content: "CSV";
				display:contents; 
				position:absolute; 
				background:url(''); 
				z-index:1; 
				top:1;
				font-size: 15px;
			}
			.nav-item button{
				display: flex;
				flex-direction: column;
				align-items: center;
			}
			.nav-link span{
				color: black;
				font-size: 12px;
			}
			.nav-link {
				color: black;
			}
			.nav-tabs .nav-link.active, .nav-tabs .show>.nav-link {
				color: var(--bs-nav-tabs-link-active-color);
				background-color: transparent;
				box-shadow: inset 0px 0rem 1rem 12px white;
			}
			.nav-tabs .nav-link.active::before {
				content: "";
				width: 20px;
				height: 3px;
				margin-left: 21px;
				background-color: transparent;
				position: absolute;
				-webkit-transform: translateX(-50%);
				transform: translateX(-50%);
				font-size: 36px;
			}
			.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
			    border-color: #fff0 #fff0 #f39800;
			}

			input[type="month"]::before{
			  content: attr(placeholder) !important;
			  color: #aaa;
			  width: 100%;
			}

			input[type="month"]:focus::before,
			input[type="month"]:valid::before {
			  display: none;
			}
		</style>
</head>
<body>
		<header class="container">
			<div class="text-end"><i class="bi bi-person-circle"></i>
				<?php echo get_current_username(); ?>様ようこそ |
			</div>
		</header>
		<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
	      <ol class="breadcrumb">
	        <li class="breadcrumb-item"><a href="<?php echo create_link(base_url('admin/index.php'), array('m' => 'common', 'a' => 'dashboard')); ?>">Home</a></li>
	        <li class="breadcrumb-item active" aria-current="page">CSVダウンロード</li>
	      </ol>
	    </nav>
		<div class="container-fruid">
			<ul class="nav nav-tabs d-flex justify-content-evenly row" id="pills-tab" role="tablist">
			  <li class="nav-item col-6 col-sm-3" role="presentation">
				<a class="nav-link" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" role="tab" aria-controls="pills-1" aria-selected="true">
					<div class="card rounded-9 text-center">
						<i class="bi bi-download bi-download-style" style="font-size: 53.34px;"></i>
						<p class="card-text">入庫履歴</p>
					</div>
				</a>
			  </li>
			 <li class="nav-item col-6 col-sm-3" role="presentation">
				<a class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" role="tab" aria-controls="pills-2" aria-selected="true">
					<div class="card rounded-9 text-center">
						<i class="bi bi-upload bi-upload-style" style="font-size: 53.34px;"></i>
						<p class="card-text">出庫履歴</p>
					</div>
				</a>
			  </li>
			  <li class="nav-item col-6 col-sm-3" role="presentation">
				<a class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" role="tab" aria-controls="pills-3" aria-selected="true">
					<div class="card rounded-9 text-center">
						<i class="bi bi-box-seam" style="font-size: 53.34px;"></i>
						<p class="card-text">在庫一覧CSV</p>
					</div>
				</a>
			  </li>
			  <li class="nav-item col-6 col-sm-3" role="presentation">
				<a class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" role="tab" aria-controls="pills-4" aria-selected="true">
					<div class="card rounded-9 text-center">
						<i class="bi bi-upc-scan" style="font-size: 53.34px;"></i>
						<p class="card-text">コード画像CSV</p>
					</div>
				</a>
			  </li>
			</ul>
		</div>
		<div class="container-fruid">
			<div class="tab-content" id="pills-tabContent">
			  <div class="tab-pane fade" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab"><?php include('add_item_csv.php'); ?></div>
			  <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab"><?php include('remove_item_csv.php'); ?></div>
			  <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab"><?php include('ExportIchiran.php'); ?></div>
			  <div class="tab-pane fade" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab"><?php include('qr_list_csv.php'); ?></div>
			</div>
		</div>
<?php include_once('widgets/footer.php'); ?>