<?php
session_start();
require_once 'C:\xampp\htdocs\dolicha0.2\controller\productController.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo '<p>Votre panier est vide.</p>';
    exit();
}

$productController = new ProductController($pdo);
$cart = $_SESSION['cart'];
$total = 0;
?>

!<DOCTYPE html>
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
                    <h1 class="text-white">View Cart</h1>
                    <p class="text-white link-nav"><a href="index.html">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="insurance.php"> Products</a> <span class="lnr lnr-arrow-right"></span>  <a href="view_cart.php"> View cart</a></p>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <h1>Votre Panier</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $productId => $quantity): ?>
                    <?php
                    $product = $productController->getProductById($productId);
                    if ($product === null) {
                        echo '<tr><td colspan="5">Produit introuvable (ID: ' . htmlspecialchars($productId) . ').</td></tr>';
                        continue;
                    }
                    $subtotal = $product->getPrix() * $quantity;
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product->getNom()); ?></td>
                        <td><?php echo htmlspecialchars($product->getPrix()); ?> $</td>
                        <td><?php echo htmlspecialchars($quantity); ?></td>
                        <td><?php echo htmlspecialchars($subtotal); ?> $</td>
                        <td>
                            <form action="remove_from_cart.php" method="post">
                                <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total: <?php echo $total; ?> $</h3>
        <form action="confirm_cart.php" method="post">
        <label for="nom_client">Nom Client:</label>
        <input type="text" id="nom_client" name="nom_client" required>
            <button type="submit" class="btn btn-success">Confirmer le Panier</button>
        </form>
    </div>
</body>
</html>