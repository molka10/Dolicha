<?php
// Include necessary files
require_once 'C:\xampp\htdocs\dolicha0.2\controllers\cartController.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';
// Create a new PDO instance
try {
    $pdo = new PDO('mysql:host=localhost;dbname=dolicha0.2', 'root', ''); // Adjust these values
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit; // Stop execution if the connection fails
}

// Create a new CartController object
$cartController = new PanierController($pdo);

// Fetch all carts using the CartController
$carts = $cartController->getAllPanier();
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

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .action-links {
            display: flex;
            gap: 10px;
        }

        .delete-link {
            color: red;
            text-decoration: none;
        }

        .delete-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th {
                display: none; /* Hide headers on small screens */
            }
            td {
                text-align: right;
                position: relative;
                padding-left: 50%; /* Add space for labels */
            }
            td:before {
                content: attr(data-label); /* Use data-label for headers */
                position: absolute;
                left: 10px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
            }
        }
    </style>
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
                        <li><a href="index.php">Home</a></li>
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
                    <h1 class="text-white">View All Carts</h1>
                    <p class="text-white link-nav"><a href="index.php">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="indexp.php"> Products</a> <span class="lnr lnr-arrow-right"></span> <a href="affichepanier.php"> View all carts</a></p>
                </div>
            </div>
        </div>
    </section>


    <h1>Cart Management</h1>

<!-- Table to display the cart information -->
<table id="cartTable" data-sort-order="asc">
    <thead>
        <tr>
            <th onclick="sortTable(0)">ID Panier &#x25B2;&#x25BC;</th>
            <th onclick="sortTable(1)">Total &#x25B2;&#x25BC;</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($carts as $cart): ?>
            <tr>
                <td data-label="ID Panier"><?php echo htmlspecialchars($cart['Idpanier']); ?></td>
                <td data-label="Total" class="total"><?php echo htmlspecialchars(number_format($cart['total'], 2)); ?> €</td>
                <td data-label="Status">
                    <?php echo htmlspecialchars($cart['status'] == 0 ? 'Not Confirmed' : 'Confirmed'); ?>
                </td>
                <td data-label="Actions" class="action-links">
                    <a href="update_cart.php?id=<?php echo $cart['Idpanier']; ?>">Update</a>
                    <a href="delete_cart.php?id=<?php echo $cart['Idpanier']; ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this cart?');">Delete</a>
                    <a href="view_products.php?id=<?php echo $cart['Idpanier']; ?>">View Products</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
function sortTable(columnIndex) {
    const table = document.getElementById("cartTable");
    const tbody = table.tBodies[0];
    const rows = Array.from(tbody.rows);
    const isAscending = table.getAttribute('data-sort-order') === 'asc';

    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();

        // Convert to number for ID Panier sorting and keep as string for others
        return columnIndex === 0 ? (isAscending ? aText - bText : bText - aText) : (isAscending ? parseFloat(aText.replace(' €', '').replace(',', '.')) - parseFloat(bText.replace(' €', '').replace(',', '.')) : parseFloat(bText.replace(' €', '').replace(',', '.')) - parseFloat(aText.replace(' €', '').replace(',', '.')));
    });

    rows.forEach(row => tbody.appendChild(row)); // Reorder the rows in the table body
    table.setAttribute('data-sort-order', isAscending ? 'desc' : 'asc'); // Toggle sort order
}
</script>

<style>
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    cursor: pointer; /* Indicate that the column is clickable */
}

th:hover {
    background-color: #f1f1f1; /* Highlight on hover */
}
</style>
    <footer  >
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