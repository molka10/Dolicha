<?php
// Include necessary files
require_once 'C:\xampp\htdocs\dolicha0.2\controller\comandeController.php'; // Corrected to lowercase 'c'
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

// Create a new PDO instance
try {
    $pdo = new PDO('mysql:host=localhost;dbname=dolicha0.2', 'root', ''); // Adjust these values as needed
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit; // Stop execution if the connection fails
}

// Create a new CommandeController object
$commandeController = new CommandeController($pdo);

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $idcommande = $_GET['id'];
    $commande = $commandeController->getCommandeById($idcommande);

    if (!$commande) {
        echo "Commande not found.";
        exit;
    }
} else {
    echo "No ID provided.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form values
    $iduser = $_POST['iduser'];
    $idpanier = $_POST['idpanier'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Check the status and delete if 'Not Confirmed'
    if ($status == 0) { // Assuming 0 means 'Not Confirmed'
        $sql = "DELETE FROM commande WHERE idcommande = :idcommande";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['idcommande' => $idcommande]);

        // Redirect to affichecommande.php after deletion
        header("Location: affichecommande.php");
        exit;
    } else {
        // Update the commande in the database
        $sql = "UPDATE commande SET iduser = :iduser, idpanier = :idpanier, date = :date, status = :status WHERE idcommande = :idcommande";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'iduser' => $iduser,
            'idpanier' => $idpanier,
            'date' => $date,
            'status' => $status,
            'idcommande' => $idcommande
        ]);

        // Redirect to affichecommande.php after update
        header("Location: affichecommande.php");
        exit;
    }
}
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
                    <h1 class="text-white">Commande</h1>
                    <p class="text-white link-nav"><a href="index.html">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="insurance.php"> Products</a> <span class="lnr lnr-arrow-right"></span> <a href="affichecommande.php">Commande</a></p>
                </div>
            </div>
        </div>
    </section>
    <title>Update Commande</title>
</head>
<body>
    <div class="container">
        <h1>Update Commande</h1>
        <form method="POST">
            <div class="form-group">
                <label for="iduser">ID User</label>
                <input type="text" class="form-control" id="iduser" name="iduser" value="<?php echo htmlspecialchars($commande->getIduser()); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="idpanier">ID Panier</label>
                <input type="text" class="form-control" id="idpanier" name="idpanier" value="<?php echo htmlspecialchars($commande->getIdpanier()); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($commande->getDate()->format('Y-m-d')); ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="0" <?php echo $commande->getStatus() == 0 ? 'selected' : ''; ?>>Not Confirmed</option>
                    <option value="1" <?php echo $commande->getStatus() == 1 ? 'selected' : ''; ?>>Confirmed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
</body>
</html>