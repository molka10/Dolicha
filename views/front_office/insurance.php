<?php
require_once 'C:\xampp\htdocs\dolicha0.2\controller\productController.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

// Initialize the ProductController
$productController = new ProductController($pdo);

// Fetch all products
$products = $productController->getAllProducts();
?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="colorlib">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Travel</title>

    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">                
    <link rel="stylesheet" href="css/nice-select.css">                            
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/owl.carousel.css">                
    <link rel="stylesheet" href="css/main.css">
</head>
<body>    
    <header id="header">
        <div class="header-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-6 col-6 header-top-left">
                        <ul>
                            <li><a href="#">Visit Us</a></li>
                            <li><a href="#">Buy Tickets</a></li>
                        </ul>            
                    </div>
                    <div class="col-lg-6 col-sm-6 col-6 header-top-right">
                        <div class="header-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-dribbble"></i></a>
                            <a href="#"><i class="fa fa-behance"></i></a>
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
        <div class="container main-menu">
            <div class="row align-items-center justify-content-between d-flex">
                <div id="logo">
                    <a href="index.html"><img src="img/logo.png" alt="" title="" /></a>
                </div>
                <nav id="nav-menu-container">
                    <ul class="nav-menu">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="packages.html">Packages</a></li>
                        <li><a href="hotels.html">Hotels</a></li>
                        <li><a href="insurance.html">Insurance</a></li>
                        <li class="menu-has-children"><a href="">Blog</a>
                            <ul>
                                <li><a href="blog-home.html">Blog Home</a></li>
                                <li><a href="blog-single.html">Blog Single</a></li>
                            </ul>
                        </li>    
                        <li class="menu-has-children"><a href="">Pages</a>
                            <ul>
                                <li><a href="elements.html">Elements</a></li>
                                <li class="menu-has-children"><a href="">Level 2</a>
                                    <ul>
                                        <li><a href="#">Item One</a></li>
                                        <li><a href="#">Item Two</a></li>
                                    </ul>
                                </li>                                      
                            </ul>
                        </li>                                        
                        <li><a href="contact.html">Contact</a></li>
                        <!-- New Buttons for Cart -->
                        <li><a href="view_cart.php"><i class="fa fa-shopping-cart"></i> View Cart</a></li>
                        <li><a href="affichepanier.php"><i class="fa fa-shopping-cart"></i> View All Carts</a></li>
                        <li><a href="affichecommande.php"><i class="fa fa-shopping-cart"></i> Commandes</a></li>
                    </ul>
                </nav><!-- #nav-menu-container -->                          
            </div>
        </div>
    </header>

    <section class="about-banner relative">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">Products</h1>
                    <p class="text-white link-nav"><a href="index.html">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="insurance.php"> Products</a></p>
                </div>
            </div>
        </div>
    </section>

    <section class="product-section section-gap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <h2 class="section-title">Featured Products</h2>
                    <div class="row">
                        <?php
                        if (!empty($products)) {
                            foreach ($products as $product) {
                                echo '
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="single-product">
                                        <img src="img/product-placeholder.jpg" alt="' . htmlspecialchars($product->getNom()) . '" class="img-fluid">
                                        <h3 class="product-name">' . htmlspecialchars($product->getNom()) . '</h3>
                                        <p class="product-description">Experience the best of ' . htmlspecialchars($product->getNom()) . '!</p>
                                        <span class="product-price">$' . htmlspecialchars($product->getPrix()) . '</span>
                                        <form action="add_to_cart.php" method="post">
                                            <input type="hidden" name="productId" value="' . htmlspecialchars($product->getIdproduit()) . '">
                                            <input type="hidden" name="userId" value="1">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>';
                            }
                        } else {
                            echo '<p>No products found.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-area section-gap">
        <!-- Your footer content -->
    </footer>

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.magnific-popup.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>
</body>
</html>