<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Frosty Business </title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon.ico"/>
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.ico"/>
    <link rel="manifest" href="assets/images/favicons/site.webmanifest" />
    <meta name="description" content="Frosty Business" />

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
        
        <!--Main Slider Start-->
        <section class="main-slider">
            <?php include("inc_files/slider.php"); ?>
        </section>
        <!--Main Slider End-->

        <!--About One Start-->
        <section class="about-one">
            <?php include("inc_files/about_section.php"); ?>
        </section>
        <!--About One End-->

        <!--Counter One Start-->
        <section class="counter-one">
            <?php include("inc_files/counter.php"); ?>            
        </section>
        <!--Counter One End-->

        <!--Services One Start-->
        <section class="services-one">
            <?php include("inc_files/service.php"); ?>            
        </section>
        <!--Services One End-->

        <!--Project One Start-->
        <section class="project-one">
            <!-- <?php include("inc_files/project_section.php"); ?> -->
        </section>
        <!--Project One End-->

        <!--Trusted One Start-->
        <section class="trusted-one">
            <?php include("inc_files/trust_one_section.php"); ?>              
        </section>
        <!--Trusted One End-->

        <!--Best Construction Start-->
        <section class="best-construction">
            <?php include("inc_files/best_construction.php"); ?>             
        </section>
        <!--Best Construction End-->

        <!--Team One Start-->
        <section class="team-one">
            <!-- <?php include("inc_files/teams.php"); ?>  -->
        </section>
        <!--Team One End-->

        <!--Brand One Start-->
        <section class="brand-one">
            <?php include("inc_files/brand_slider.php"); ?>            
        </section>
        <!--Brand One End-->

        <!--Testimonial One Start-->
        <section class="testimonial-one">
            <?php include("inc_files/testimonial_section.php"); ?>             
        </section>
        <!--Testimonial One End-->

        <!--News One Start-->
        <section class="news-one">
            <?php include("inc_files/news_one.php"); ?>            
        </section>
        <!--News One End-->

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