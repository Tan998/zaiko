<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
<?php include_once('widgets/header.php'); ?>
        <style type="text/css">

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
                        .nav-pills .nav-link.active::before {
                          content: "";
                          width: 20px;
                          height: 3px;
                          margin-left: 21px;
                          background-color: #c1e8ff;
                          position: absolute;
                          -webkit-transform: translateX(-50%);
                          transform: translateX(-50%);
                          font-size: 36px;
                        }
                        .row {
                            margin: 0;
                        }
                        .nav_ul_style {
                            background-color: white;
                            margin-bottom: 25px;
                            min-width: 310px;
                            overflow-x: auto;
                            background-color: antiquewhite;
                        }
                        .nav_ul_style li {
                            min-width: 80px;
                        }
                        .nav_ul_style li button{
                            width: 100%;
                        }
                        i {
                            font-size: 20px;
                            font-weight: bold;
                        }

        </style>
    </head>
    <body>
        <!--User-->
        <?php if (is_logged()){ ?>
            <header class="container">
            <div class="text-end">
                <?php echo get_current_username(); ?>様ようこそ |
            </div>
            
            </header>
            <div class="container-fruid">
                <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade <?php echo_text("",""," show active") ?>" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                            <?php include('./manager_page/home_page.php'); ?>
                        </div>
                        <div class="tab-pane fade" id="pills-zaiko" role="tabpanel" aria-labelledby="pills-zaiko-tab" tabindex="0">
                            <?php include('./manager_page/zaiko_ichiran.php'); ?>
                        </div>
                        <div class="tab-pane fade <?php echo_text(" show active","","") ?>" id="pills-nyuko" role="tabpanel" aria-labelledby="pills-nyuko-tab" tabindex="0">
                            <?php include('./manager_page/nyuko_ichiran.php'); ?>
                        </div>
                        <div class="tab-pane fade <?php echo_text(""," show active","") ?>" id="pills-syukko" role="tabpanel" aria-labelledby="pills-syukko-tab" tabindex="0">
                            <?php include('./manager_page/syukko_ichiran.php'); ?>
                        </div>
                </div>
            </div>
                <ul class="nav_ul_style nav nav-pills fixed-bottom d-flex justify-content-around shadow-lg" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo_text("","","active") ?>" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="<?php echo_text("false","false","true") ?>">
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
                        <button class="nav-link <?php echo_text("active","","") ?>" id="pills-nyuko-tab" data-bs-toggle="pill" data-bs-target="#pills-nyuko" type="button" role="tab" aria-controls="pills-nyuko" aria-selected="<?php echo_text("true","","false") ?>">
                            <i class="bi bi-download"></i>
                            <span>入庫一覧</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo_text("","active","") ?>" id="pills-syukko-tab" data-bs-toggle="pill" data-bs-target="#pills-syukko" type="button" role="tab" aria-controls="pills-syukko" aria-selected="<?php echo_text("","true","false") ?>">
                            <i class="bi bi-upload"></i>
                            <span>出庫一覧</span>
                        </button>
                    </li>
                </ul>
        <?php } ?>
                <?php 
                    function echo_text($text1,$text2,$text3){
                    if (isset($_GET['nyuko-ichiran']) && $_GET['nyuko-ichiran'] == "true"){
                        echo $text1;}
                    elseif(isset($_GET['syukko-ichiran']) && $_GET['syukko-ichiran'] == "true"){
                        echo $text2;}
                    else{echo $text3;}
                    }
                ?>
<?php include_once('widgets/footer.php'); ?>