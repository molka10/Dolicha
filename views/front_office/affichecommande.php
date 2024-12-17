<?php
// Include necessary files
require_once 'C:\xampp\htdocs\dolicha0.2\controller\ComandeController.php';
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

// Create a new PDO instance
try {
    $pdo = new PDO('mysql:host=localhost;dbname=dolicha0.2', 'root', ''); // Adjust these values
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit; // Stop execution if the connection fails
}

// Create a new CommandeController object
$commandeController = new CommandeController($pdo);

// Fetch all commandes using the CommandeController
$commandes = $commandeController->getAllCommandes();
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
                        <li><a href="affichecommande.php"><i class="fa fa-shopping-cart"></i> Historique</a></li>

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
                    <h1 class="text-white">Historique</h1>
                    <p class="text-white link-nav"><a href="index.html">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="insurance.php"> Products</a> <span class="lnr lnr-arrow-right"></span> <a href="affichecommande.php">Historique</a></p>
                </div>
            </div>
        </div>
    </section>
    <title>Historiques</title>

    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f7f7f7;
            color: #333;
            padding: 20px;
        }

        header {
            
            color: white;
            padding: 40px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 40px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 3rem;
        }

        .search-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .search-bar {
            width: 70%;
            max-width: 400px;
            padding: 12px 20px;
            font-size: 1.1rem;
            border-radius: 30px;
            border: 1px solid #ddd;
            outline: none;
            background: #fff;
            transition: transform 0.2s ease;
        }

        .search-bar:focus {
            transform: scale(1.05);
            border-color: #333;
        }

        .order-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 30px; /* Increase padding for more height */
            min-height: 300px; /* Increase minimum height */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .order-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .order-card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .order-card h3 {
            font-size: 1.5rem;
            color: #333;
        }

        .order-card .status {
            font-weight: bold;
            color: #333;
        }

        .order-card .status.pending {
            color: #e74c3c; /* Red color for pending */
        }

        .order-card .details {
            margin-bottom: 15px;
            font-size: 1rem;
            color: #555;
        }

        .order-card .total {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }
        .order-card .action-buttons {
        margin-top: 20px; /* Add margin to push buttons down */
    }

        .order-card .action-buttons a {
            text-decoration: none;
            padding: 12px 20px;
            margin: 5px;
            border-radius: 5px;
            font-size: 1rem;
            color: white;
            transition: background-color 0.3s ease;
        }

        .action-buttons .update-btn {
            background-color: #888;
        }

        .action-buttons .delete-btn {
            background-color: #e74c3c; /* Red for delete */
        }

        .action-buttons .update-btn:hover {
            background-color: #555;
        }

        .action-buttons .delete-btn:hover {
            background-color: #c0392b; /* Darker red */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .order-card {
                width: 90%;
                margin: 10px auto;
            }
        }
        /* Sorting Buttons Container */
.sorting-buttons {
    display: flex;
    justify-content: center; /* Center align the buttons horizontally */
    margin-bottom: 20px;
    gap: 15px; /* Adds space between the buttons */
}

/* Styling for Sorting Buttons */
.sorting-buttons button {
    background-color: #4CAF50; /* Green background */
    color: white; /* White text */
    padding: 10px 20px; /* Adjust padding for better size */
    border: none; /* Remove default border */
    border-radius: 5px; /* Rounded corners */
    font-size: 16px; /* Font size */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition for background and transform */
}

/* Hover Effects for Buttons */
.sorting-buttons button:hover {
    background-color: #45a049; /* Darker green on hover */
    transform: scale(1.05); /* Slightly enlarge the button on hover */
}

/* Active Button State (for clicked button) */
.sorting-buttons button:active {
    background-color: #388e3c; /* Even darker green when clicked */
    transform: scale(1.1); /* Slightly larger when clicked */
}


    </style>
</head>
<body>
    <header>
        <h1>Historiques</h1>
    </header>

    <div class="search-container">
        <input type="text" id="search" class="search-bar" onkeyup="filterTable()" placeholder="🔍 Search by Nom Client...">
    </div>

    <!-- Sorting Buttons: Place them above or below the search bar -->
    <div class="sorting-buttons">
    <button class="sort-total" onclick="sortTable('data-total')">Sort by Total</button>
    <button class="sort-date" onclick="sortTable('data-date')">Sort by Date</button>
</div>


    <div class="order-container" id="orderContainer">
        <!-- Dynamically generated cards for each order -->
        <?php foreach ($commandes as $commande): ?>
            <div class="order-card" data-id="<?php echo htmlspecialchars($commande['idcommande']); ?>" data-client="<?php echo htmlspecialchars($commande['nom_client']); ?>" data-status="<?php echo $commande['status']; ?>" data-total="<?php echo $commande['total']; ?>" data-date="<?php echo $commande['date']; ?>">
                <div class="card-header">
                    <h3>Commande #<?php echo htmlspecialchars($commande['idcommande']); ?></h3>
                    <span class="status <?php echo $commande['status'] == 1 ? '' : 'pending'; ?>">
                        <?php echo $commande['status'] == 1 ? 'Confirmed' : 'Pending'; ?>
                    </span>
                </div>
                <div class="details">
                    <p><strong>Client:</strong> <?php echo htmlspecialchars($commande['nom_client']); ?></p>
                    <p><strong>Panier ID:</strong> <?php echo htmlspecialchars($commande['Idpanier']); ?></p>
                    <p><strong>Date:</strong> 
                        <?php 
                        $date = new DateTime($commande['date']);
                        echo $date->format('d/m/y');
                        ?>
                    </p>
                </div>
                <div class="total">
                    <strong>Total:</strong> $<?php echo htmlspecialchars($commande['total']); ?>
                </div>
                <div class="action-buttons">
                    <a href="update_commande.php?id=<?php echo $commande['idcommande']; ?>" class="update-btn">Update</a>
                    <a href="delete_commande.php?id=<?php echo $commande['idcommande']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<script>
    // Filter function to search by Nom Client in dynamically generated cards
    function filterTable() {
        var input = document.getElementById("search");
        var filter = input.value.toUpperCase();
        var orderCards = document.getElementsByClassName("order-card");

        for (var i = 0; i < orderCards.length; i++) {
            var client = orderCards[i].getAttribute("data-client");
            if (client.toUpperCase().indexOf(filter) > -1) {
                orderCards[i].style.display = ""; // Show the card
            } else {
                orderCards[i].style.display = "none"; // Hide the card
            }
        }
    }

    // Sort function to sort cards by Total or Date (numeric or date values)
    function sortTable(attribute) {
        var orderCards = Array.from(document.getElementsByClassName("order-card"));
        var isAscending = document.getElementById("orderContainer").getAttribute('data-sort-order') === 'asc';

        orderCards.sort(function(a, b) {
            var aText = a.getAttribute(attribute);
            var bText = b.getAttribute(attribute);

            if (attribute === "data-total") { // Sort by numeric values (Total)
                aText = parseFloat(aText.replace('$', '').trim()) || 0;
                bText = parseFloat(bText.replace('$', '').trim()) || 0;
            } else if (attribute === "data-date") { // Sort by Date
                aText = new Date(aText);
                bText = new Date(bText);
            }

            return isAscending ? aText > bText ? 1 : -1 : aText < bText ? 1 : -1;
        });

        // Append sorted cards back to the container
        var container = document.querySelector(".order-container");
        orderCards.forEach(function(card) {
            container.appendChild(card);
        });

        // Toggle sort order
        document.getElementById("orderContainer").setAttribute('data-sort-order', isAscending ? 'desc' : 'asc');
    }
</script>
</body>



    <footer>
        <!-- Your footer content -->
    </footer>

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>