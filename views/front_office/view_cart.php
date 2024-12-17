<?php
session_start();
require_once 'C:\xampp\htdocs\dolicha0.2\controller\productController.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

$productController = new ProductController($pdo);
$cart = $_SESSION['cart'] ?? [];
$total = 0;

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
    <style>
        /* Add hover effect for table rows */
        .table tbody tr:hover {
            transform: scale(1.02);
            transition: transform 0.3s ease-in-out;
            background-color: #f8f9fa;
        }

        /* Add hover effect for the delete button */
        .table .btn-danger:hover {
            background-color: #dc3545;
            transform: scale(1.1);
            transition: transform 0.3s ease-in-out;
        }

        /* Add a smooth transition to the table */
        .table {
            transition: all 0.3s ease;
        }

        /* Add a fade-in effect for the cart items */
        .table tbody tr {
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Remove the animation for total price */
        .total {
            font-weight: bold;
            font-size: 1.5rem;
            margin-top: 20px;
            text-align: right;
            color: #333;
        }

        /* Background for the cart section */
        .cart-section {
            background: linear-gradient(135deg, #f3f4f7 0%, #e2e6ea 100%);
            padding: 30px;
            border-radius: 10px;
        }

        /* Fancy hover effect for the table rows */
        .table tbody tr:hover {
            background-color: #e9ecef;
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

    </style>
    <script>
        // Animate the quantity change
        document.querySelectorAll('.table .btn-danger').forEach(button => {
            button.addEventListener('click', function () {
                let quantityCell = this.closest('tr').querySelector('td:nth-child(3)');
                let originalQuantity = parseInt(quantityCell.innerText);
                
                quantityCell.innerText = originalQuantity - 1;
                
                // Add animation effect
                quantityCell.classList.add('quantity-change');
                setTimeout(() => {
                    quantityCell.classList.remove('quantity-change');
                }, 300);
            });
        });
    </script>
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
                        
                        <li><a href="affichecommande.php"><i class="fa fa-shopping-cart"></i> Historique</a></li>
                    </ul>
                </nav><!-- #nav-menu-container -->                          
            </div>
        </div>
    </header>
    
    <!-- Banner Section -->
    <section class="about-banner relative">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center" style="position: relative;">
                <div class="about-content col-lg-12 text-center">
                    <h1 class="text-white" style="font-size: 2rem; font-weight: bold;">View Cart</h1>
                    <p class="text-white link-nav" style="font-size: 1.2rem;">
                        <a href="index.html" class="text-white">Home </a>  
                        <span class="lnr lnr-arrow-right"></span>  
                        <a href="insurance.php" class="text-white"> Products</a> 
                        <span class="lnr lnr-arrow-right"></span>  
                        <a href="view_cart.php" class="text-white"> View cart</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <div class="container">
        <h1 class="cart-title">Votre Panier</h1>
        <div class="cart-items">
            <?php foreach ($cart as $productId => $quantity): ?>
                <?php
                $product = $productController->getProductById($productId);
                if ($product === null) {
                    echo '<div class="cart-item">Produit introuvable (ID: ' . htmlspecialchars($productId) . ').</div>';
                    continue;
                }
                $subtotal = $product->getPrix() * $quantity;
                $total += $subtotal;
                ?>
                <div class="cart-item">
                    <div class="item-info">
                        <div class="item-name"><?php echo htmlspecialchars($product->getNom()); ?></div>
                        <div class="item-price"><?php echo htmlspecialchars($product->getPrix()); ?> $</div>
                        <div class="item-quantity">Quantité: <?php echo htmlspecialchars($quantity); ?></div>
                        <div class="item-subtotal">Sous-total: <?php echo htmlspecialchars($subtotal); ?> $</div>
                    </div>
                    <div class="item-action">
                        <form action="remove_from_cart.php" method="post">
                            <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Supprimer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <h3 class="total">Total: <?php echo $total; ?> $</h3>
        <form action="confirm_cart.php" method="post">
            <button type="submit" class="btn btn-success">Confirmer le Panier</button>
        </form>
    </div>
    
    <style>
        .cart-title {
            text-align: center;
            font-size: 2rem;
            margin-top: 20px;
            color: #444;
            font-weight: bold;
        }
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }
        .cart-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }
        .cart-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .item-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .item-name {
            font-weight: bold;
            font-size: 1.3rem;
            color: #333;
        }
        .item-price, .item-quantity, .item-subtotal {
            color: #555;
        }
        .item-action {
            margin-left: 20px;
        }
        .total {
            font-weight: bold;
            font-size: 1.5rem;
            margin-top: 20px;
            text-align: right;
            color: #333;
        }
        .btn {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</body>
</html>