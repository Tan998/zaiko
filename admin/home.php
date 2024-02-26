<!doctype html>
<html lang="en">
		<head>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<title>在庫管理</title>
				<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
				<!--icon-->
				<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
				<style>
						header {
							height: 80px;
						}
						body {
    						background-color: antiquewhite;
    						min-width: 310px;
    						min-height: 575px;
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
						.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
						    color: var(--bs-nav-pills-link-active-color);
						    background-color: #d39542;;
						}
						.row {
							margin: 0;
						}
						.nav_ul_style {
							background-color: white;
							margin-bottom: 25px;
							min-width: 310px;
							overflow-x: auto;
						}
						i {
							font-size: 20px;
							font-weight: bold;
						}
						footer {
							display: flex;
							align-items: center;
							justify-content: center;
							color: chocolate;
						}

				</style>
		</head>
		<body>
			<header></header>
			<div class="container">
				<ul class="nav_ul_style nav nav-pills fixed-bottom d-flex justify-content-around" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
							<i class="bi bi-house"></i>
							<span>HOME</span>
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="pills-zaiko-tab" data-bs-toggle="pill" data-bs-target="#pills-zaiko" type="button" role="tab" aria-controls="pills-zaiko" aria-selected="false">
							<i class="bi bi-card-checklist"></i>
							<span>在庫一覧</span>
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="pills-nyuko-tab" data-bs-toggle="pill" data-bs-target="#pills-nyuko" type="button" role="tab" aria-controls="pills-nyuko" aria-selected="false">
							<i class="bi bi-download"></i>
							<span>入庫一覧</span>
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="pills-syukko-tab" data-bs-toggle="pill" data-bs-target="#pills-syukko" type="button" role="tab" aria-controls="pills-syukko" aria-selected="false">
							<i class="bi bi-upload"></i>
							<span>出庫一覧</span>
						</button>
					</li>
				</ul>
				<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
							<?php include('./manager_page/home_page.php'); ?>
						</div>
						<div class="tab-pane fade" id="pills-zaiko" role="tabpanel" aria-labelledby="pills-zaiko-tab" tabindex="0">
							<?php include('./manager_page/zaiko_ichiran.php'); ?>
						</div>
						<div class="tab-pane fade" id="pills-nyuko" role="tabpanel" aria-labelledby="pills-nyuko-tab" tabindex="0">
							<?php include('./manager_page/nyuko_ichiran.php'); ?>
						</div>
						<div class="tab-pane fade" id="pills-syukko" role="tabpanel" aria-labelledby="pills-syukko-tab" tabindex="0">
							<?php include('./manager_page/syukko_ichiran.php'); ?>
						</div>
				</div>
			</div>

			
		</body>
		<footer class=" col-12 footer fixed-bottom">copy right by homebear 2023</footer>
</html>