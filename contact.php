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
            <div class="page-header-bg" style="background-image: url(assets/images/backgrounds/page-header-bg.jpg)">
            </div>

            <div class="container">
                <div class="page-header__inner">
                    <h2>Contact</h2>
                    <div class="thm-breadcrumb__box">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="">Home</a></li>
                            <li><span>/</span></li>
                            <li>Contact</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End-->

        <!--Contact Info Start-->
        <section class="contact-info">
            <div class="container">
                <div class="row">
                    <!--Contact Info Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="100ms">
                        <div class="contact-info__single">
                            <h4 class="contact-info__title">About</h4>
                            <p class="contact-info__text">Green Air (Frosty) delivers innovative refrigeration solutions with quality and efficiency since 2010, serving diverse industries nationwide.</p>
                            <div class="contact-info__btn-box">
                                <div class="contact-info__btn">
                                    <a href="contact.html">Contact</a>
                                </div>
                            </div>
                            <div class="contact-info__icon">
                                <span class="icon-entrepreneur"></span>
                            </div>
                        </div>
                    </div>
                    <!--Contact Info Single End-->
                    <!--Contact Info Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms">
                        <div class="contact-info__single">
                            <h4 class="contact-info__title">Contact</h4>
                            <p class="contact-info__text">Mon-Sat 8:00 - 6:30 Sunday Closed <br> <a
                                    href="mailto:greenairkol@gmail.com">greenairkol@gmail.com</a> <br> <a
                                    href="tel:+917439298028">+ 91 74392 98028</a></p>
                            <div class="contact-info__btn-box">
                                <div class="contact-info__btn">
                                    <a href="contact.html">Contact</a>
                                </div>
                            </div>
                            <div class="contact-info__icon">
                                <span class="icon-contact"></span>
                            </div>
                        </div>
                    </div>
                    <!--Contact Info Single End-->
                    <!--Contact Info Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="300ms">
                        <div class="contact-info__single">
                            <h4 class="contact-info__title">Address</h4>
                            <p class="contact-info__text">Boral Main Road, Narendrapur <br> Kolkata - 700 103</p>
                            <div class="contact-info__btn-box">
                                <div class="contact-info__btn">
                                    <a href="contact.html">Contact</a>
                                </div>
                            </div>
                            <div class="contact-info__icon">
                                <span class="icon-location"></span>
                            </div>
                        </div>
                    </div>
                    <!--Contact Info Single End-->
                </div>
            </div>
        </section>
        <!--Contact Info End-->

        <!--Contact Page Form Start-->
        <section class="contact-page-form">
            <div class="contact-page-form__shape-1 float-bob-x">
                <img src="assets/images/shapes/contact-page-form-shape-1.png" alt="">
            </div>
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Contact With Us</span>
                    <h2 class="section-title__title">Feel free to write our <br> team anytime</h2>
                </div>
                <form action="assets/inc/sendemail.php" class="contact-page-form__form-box contact-form-validated"
                    novalidate="novalidate">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="contact-page-form__input-box">
                                <input type="text" placeholder="Your name" name="name">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="contact-page-form__input-box">
                                <input type="email" placeholder="Email address" name="email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="contact-page-form__input-box text-message-box">
                                <textarea name="message" placeholder="Write message"></textarea>
                            </div>
                            <div class="contact-page-form__btn-box">
                                <button type="submit" class="thm-btn contact-page-form__btn">Send a message</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="result"></div>
            </div>
        </section>
        <!--Contact Page Form End-->

        <!--Google Map Start-->
        <section class="contact-page-google-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4562.753041141002!2d-118.80123790098536!3d34.152323469614075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80e82469c2162619%3A0xba03efb7998eef6d!2sCostco+Wholesale!5e0!3m2!1sbn!2sbd!4v1562518641290!5m2!1sbn!2sbd"
                class="google-map__two" allowfullscreen></iframe>

        </section>
        <!--Google Map End-->

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