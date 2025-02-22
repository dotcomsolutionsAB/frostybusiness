<?php  include("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("inc_files/fav_code.php"); ?>

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/vendors/animate/animate.min.css" />
    <link rel="stylesheet" href="assets/vendors/animate/custom-animate.css" />
    <link rel="stylesheet" href="assets/vendors/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assets/vendors/jarallax/jarallax.css" />
    <link rel="stylesheet" href="assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css" />
    <link rel="stylesheet" href="assets/vendors/nouislider/nouislider.min.css" />
    <link rel="stylesheet" href="assets/vendors/nouislider/nouislider.pips.css" />
    <link rel="stylesheet" href="assets/vendors/odometer/odometer.min.css" />
    <link rel="stylesheet" href="assets/vendors/swiper/swiper.min.css" />
    <link rel="stylesheet" href="assets/vendors/austry-icons/style.css">
    <link rel="stylesheet" href="assets/vendors/tiny-slider/tiny-slider.min.css" />
    <link rel="stylesheet" href="assets/vendors/reey-font/stylesheet.css" />
    <link rel="stylesheet" href="assets/vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="assets/vendors/owl-carousel/owl.theme.default.min.css" />
    <link rel="stylesheet" href="assets/vendors/bxslider/jquery.bxslider.css" />
    <link rel="stylesheet" href="assets/vendors/bootstrap-select/css/bootstrap-select.min.css" />
    <link rel="stylesheet" href="assets/vendors/vegas/vegas.min.css" />
    <link rel="stylesheet" href="assets/vendors/jquery-ui/jquery-ui.css" />
    <link rel="stylesheet" href="assets/vendors/timepicker/timePicker.css" />

    <!-- template styles -->
    <link rel="stylesheet" href="assets/css/austry.css" />
    <link rel="stylesheet" href="assets/css/austry-responsive.css" />
</head>

<body>



    <div class="preloader">
        <div class="preloader__image"></div>
    </div>
    <!-- /.preloader -->




    <div class="page-wrapper">
        <header class="main-header">
            <?php include("inc_files/top_header.php"); ?>
            <?php include("inc_files/navbar.php"); ?>
        </header>
        <?php include("inc_files/sticky_header.php"); ?>


        <!--Page Header Start-->
        <section class="page-header">
            <div class="page-header-bg" style="background-image: url(#)">
            </div>

            <div class="container">
                <div class="page-header__inner">
                    <h2>Products</h2>
                    <div class="thm-breadcrumb__box">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="">Home</a></li>
                            <li><span>/</span></li>
                            <li>Products</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End-->

        <!--Project Page Two Start-->
        <section class="project-page-two">
            <div class="container">
                <div class="row">

                    <!--Project Two Single Start-->
                    <?php
                        $sql = "SELECT p.id, p.name AS product_name, p.model, c.name AS category_name, u.file_original_name, u.path 
                                FROM products p
                                LEFT JOIN categories c ON p.category_id = c.id
                                LEFT JOIN uploads u ON p.image_id = u.id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (empty($products)) {
                            echo "<p>No products available.</p>";
                        } else {
                            foreach ($products as $product) {
                                // $imagePath = $product['image_id'] ? "assets/images/products/{$product['image_id']}.jpg" : "assets/images/default.jpg";
                                ?>
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="project-two__single">
                                        <div class="project-two__img">
                                            <img src="images/uploads/<?php echo htmlspecialchars($product['file_original_name']); ?>" alt="Product Image">
                                            <div class="project-two__arrow">
                                                <a href="product_detail.php?model=<?php echo urlencode($product['model']); ?>"><span class="icon-right-arrow"></span></a>
                                            </div>
                                        </div>
                                        <div class="project-two__content">
                                            <p class="project-two__sub-title"><b><?php echo htmlspecialchars($product['model']); ?></b></p>
                                            <h3 class="project-two__title">
                                                <a href="product_detail.php?model=<?php echo urlencode($product['model']); ?>"><?php echo htmlspecialchars($product['product_name']); ?></a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    <!--Project Two Single End-->

                    <!--Project Two Single Start-->
                    <!-- <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="project-two__single">
                            <div class="project-two__img">
                                <img src="assets/images/project/project-2-2.jpg" alt="">
                                <div class="project-two__arrow">
                                    <a href="product_detail.php"><span class="icon-right-arrow"></span></a>
                                </div>
                            </div>
                            <div class="project-two__content">
                                <p class="project-two__sub-title">02. Project</p>
                                <h3 class="project-two__title"><a href="product_detail.php">Leading Transition</a>
                                </h3>
                            </div>
                        </div>
                    </div> -->
                    <!--Project Two Single End-->

                </div>
            </div>
        </section>
        <!--Project Page Two End-->

        <!--Site Footer Start-->
        <footer class="site-footer">
            <?php include("inc_files/footer.php"); ?>            
        </footer>
        <!--Site Footer End-->


    </div><!-- /.page-wrapper -->


    <style>
        .mobile-nav__content .logo-box {
            margin-bottom: 40px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            background: #fff;
            justify-content: center;
            width: fit-content;
            padding: 5px;
        }
    </style>
    <div class="mobile-nav__wrapper">
        <?php include("inc_files/mobile_wrap.php"); ?>
    </div>
    <!-- /.mobile-nav__wrapper -->

    <div class="search-popup">
        <?php include("inc_files/searchbar_content.php"); ?>        
    </div>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>


    <script src="assets/vendors/jquery/jquery-3.6.0.min.js"></script>
    <script src="assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendors/jarallax/jarallax.min.js"></script>
    <script src="assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js"></script>
    <script src="assets/vendors/jquery-appear/jquery.appear.min.js"></script>
    <script src="assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js"></script>
    <script src="assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="assets/vendors/jquery-validate/jquery.validate.min.js"></script>
    <script src="assets/vendors/nouislider/nouislider.min.js"></script>
    <script src="assets/vendors/odometer/odometer.min.js"></script>
    <script src="assets/vendors/swiper/swiper.min.js"></script>
    <script src="assets/vendors/tiny-slider/tiny-slider.min.js"></script>
    <script src="assets/vendors/wnumb/wNumb.min.js"></script>
    <script src="assets/vendors/wow/wow.js"></script>
    <script src="assets/vendors/isotope/isotope.js"></script>
    <script src="assets/vendors/countdown/countdown.min.js"></script>
    <script src="assets/vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="assets/vendors/bxslider/jquery.bxslider.min.js"></script>
    <script src="assets/vendors/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="assets/vendors/vegas/vegas.min.js"></script>
    <script src="assets/vendors/jquery-ui/jquery-ui.js"></script>
    <script src="assets/vendors/timepicker/timePicker.js"></script>
    <script src="assets/vendors/circleType/jquery.circleType.js"></script>
    <script src="assets/vendors/circleType/jquery.lettering.min.js"></script>
    <script src="assets/vendors/sidebar-content/jquery-sidebar-content.js"></script>




    <!-- template js -->
    <script src="assets/js/austry.js"></script>
</body>

</html>