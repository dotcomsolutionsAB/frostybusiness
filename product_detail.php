<?php
// Database configuration
$host = 'localhost';
$dbname = 'frostybusiness';
$username = 'frostybusiness';
$password = '1y5D^dn09';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (!isset($_GET['model'])) {
    die("Product model not specified.");
}

$productModel = $_GET['model'];

// Fetch product details
$stmt = $pdo->prepare(
    "SELECT p.id, p.name AS product_name, p.model, p.features, p.details, c.name AS category_name, u.file_original_name, u.path 
     FROM products p
     LEFT JOIN categories c ON p.category_id = c.id
     LEFT JOIN uploads u ON p.image_id = u.id
     WHERE p.model = :model"
);
$stmt->execute(['model' => $productModel]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

// Process features if present
$features = [];
if (!empty($product['features']) && stripos($product['features'], '<ul>') !== false) {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="UTF-8">' . $product['features']);
    libxml_clear_errors();

    $listItems = $dom->getElementsByTagName('li');
    foreach ($listItems as $item) {
        $text = trim($item->textContent);
        // Filter out empty or meaningless feature items
        if (!empty($text) && !preg_match('/^Feature \\d+:?\\s*$/i', $text)) {
            $features[] = $text;
        }
    }
}


// Assuming the product details field contains the HTML table
$detailsRaw = $product['details']; 

// Check if details are present
if (!empty($detailsRaw)) {
    // Create a new DOMDocument object to parse the HTML
    $dom = new DOMDocument();
    
    // Load the HTML content into the DOM object
    libxml_use_internal_errors(true);  // Suppress warnings for malformed HTML
    $dom->loadHTML('<?xml encoding="UTF-8">' . $detailsRaw);  // Prevent warnings related to encoding
    libxml_clear_errors();
    
    // Get all the table rows
    $rows = $dom->getElementsByTagName('tr');
    
    // Initialize an array to hold the processed details
    $detailsRows = [];
    
    foreach ($rows as $row) {
        $cells = $row->getElementsByTagName('td');
        
        // Ensure there are exactly two cells (key and value)
        if ($cells->length == 2) {
            $key = trim($cells->item(0)->textContent);  // Extract the key (left column)
            $value = trim($cells->item(1)->textContent); // Extract the value (right column)
            
            // Clean up the key (e.g., remove leading underscores)
            $key = ltrim($key, '_');
            
            // Add the key-value pair to the array if value is not empty or N/A
            if (!empty($value) && strtolower($value) !== 'n/a') {
                $detailsRows[] = [$key, $value];
            }
        }
    }
} else {
    $detailsRows = [];
}
?>
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
                    <h2>Product Details</h2>
                    <div class="thm-breadcrumb__box">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="">Home</a></li>
                            <li><span>/</span></li>
                            <li>Product</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End-->

        <!--Project Details Start-->
        <section class="project-details">
            <div class="container">
                <?php if (!empty($product['path'])): ?>
                <div class="project-details__img">
                    <img src="<?php echo htmlspecialchars($product['path']); ?>" alt="Product image">
                </div>
                <?php else: ?>
                     <p><em>No image available.</em></p>
                <?php endif; ?>
                <div class="project-details__content">
                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="project-details__content-left">
                                <h3 class="project-details__title-1"><?php echo htmlspecialchars($product['product_name']); ?></h3> 
                                <h4 class="hh">
                                    <p><span style="color:grey;">Category : </span><?php echo htmlspecialchars($product['category_name']); ?></p>
                                    <br>
                                    <p><span style="color:grey;">Model : </span><?php echo htmlspecialchars($product['model']); ?></p>
                                </h4>                                 
                                <div class="project-details__img-and-points">      
                                    <?php if (!empty($features)): ?>
                                        <p><strong>Features:</strong></p>
                                        <ul class="project-details__points-list list-unstyled">
                                            <?php foreach ($features as $feature): ?>
                                                <li>
                                                    <div class="icon">
                                                        <span>&#10003;</span>
                                                    </div>
                                                    <div class="text">
                                                        <p>
                                                            <?php
                                                                $input = htmlspecialchars($feature); // Assume it returns "Feature 1 Feature 2"
                                                                $output = str_replace('Feature', '', $input); // Remove all occurrences of "Feature"
                                                                echo trim($output); // Output: "1 2"                                                                                               
                                                            ?>
                                                        </p>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>                             
                            </div>
                        </div>
<style>
    .hh{
        display: flex;
        justify-content: space-evenly;
    }
    .details_table{
        /* width:400px !important; */
    }
    .details_table thead{
        background: #dcae53f7 !important;
        color: #fff !important;
        text-align: center !important;
    }
    .details_table tbody{
        background: #b68b37e3 !important;
        text-align: justify !important;
        color: #fff !important;
    }
    .details_table th,td{
        border: 2px solid #f5f5f5 !important;
        width: fit-content;
        padding: 5px 10px 5px 10px
    }

    @media (min-width: 480px) {
        .details_table{
            /* width: 350px !important; */
        }
    }
</style>
                        <div class="col-xl-4 col-lg-5">
                            <div class="project-details__content-right">
                                <div class="project-details__info">
                                <p class="project-details__text-1">
                                    <?php if (!empty($detailsRows)): ?>
                                        <p style="color:#fff;"><strong>Details:</strong></p>
                                        <table class="details_table">
                                            <thead>
                                                <tr>
                                                    <th>Property</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($detailsRows as $row): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row[0]); ?></td>
                                                        <td><?php echo htmlspecialchars($row[1]); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>                                                    
                                    <?php else: ?>
                                        <p><em>No details available.</em></p>
                                    <?php endif; ?>
                                </p>
                                    <!-- <ul class="list-unstyled project-details__info-list">
                                        <li>
                                            <p>Category</p>
                                            <h4>NAAA</h4>
                                        </li>                                
                                    </ul> -->
                                    <!-- <div class="project-details__social">
                                        <a href="#"><i class="fab fa-twitter"></i></a>
                                        <a href="#"><i class="fab fa-facebook"></i></a>
                                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                        <a href="#"><i class="fab fa-instagram"></i></a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="project-details__pagination-box">
                    <ul class="project-details__pagination list-unstyled clearfix">
                        <li class="next">
                            <a href="#" aria-label="Previous"><i class="icon-left-arrow"></i>Previous</a>
                        </li>
                        <li class="count"><a href="#"></a></li>
                        <li class="count"><a href="#"></a></li>
                        <li class="count"><a href="#"></a></li>
                        <li class="count"><a href="#"></a></li>
                        <li class="previous">
                            <a href="#" aria-label="Next">Next<i class="icon-right-arrow"></i></a>
                        </li>
                    </ul>
                </div> -->
            </div>
        </section>
        <!--Project Details End-->

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