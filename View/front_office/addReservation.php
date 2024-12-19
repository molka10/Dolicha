<?php
// Include necessary files
include 'C:\xampp\htdocs\dolichafinalCopy\controllers\ReservationC.php';

// Create a ReservationC instance
$ReservationC = new ReservationC();
$eventId = $_GET['eventId'] ?? null;
if (
    isset($_POST["eventId"]) &&
    isset($_POST["name"]) &&
    isset($_POST["email"])
) {
    if (
        !empty($_POST["eventId"])&&
        !empty($_POST["name"]) &&
        !empty($_POST["email"])
    ) {
       
        // Créer une instance de la classe Hotel avec les données fournies
        $Reservation = new Reservation(
            null, // Laissez null pour que l'ID soit auto-incrémenté
            $_POST['eventId'],
            $_POST['name'],
            $_POST['email']
        );
        // Ajouter l'hotel
        $ReservationC->addReservation($Reservation);
        // Rediriger vers une page de succès ou effectuer une autre action en cas d'ajout réussi
        header('Location: ../front_office/packages.php');
        exit;
    } else {
        $error = "Tous les champs doivent être remplis";
    }}


// Fetch event information from the database
try {
    // Database connection (you can move this to a separate file for reuse)
    $pdo = new PDO('mysql:host=localhost;dbname=dolicha', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Prepare and execute the query to fetch event details based on eventId
    $query = "SELECT * FROM events WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$eventId]);
    
    // Fetch the event data
    $event_info = $statement->fetch(PDO::FETCH_ASSOC);

    // If no event is found, redirect to the event list page
    

    // Extract event data
    $eventName = $event_info['nom'];
    $eventDesc = $event_info['description'];
    $eventImage = $event_info['image'];  // Assuming it's a URL or file path to the event image

} catch (PDOException $e) {
    // Handle database connection errors
    die("Database error: " . $e->getMessage());
}


?>



<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="C:\Users\Houyem\Pictures\dolicha\tun.jpg">
    <!-- Author Meta -->
    <meta name="author" content="colorlib">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Dolicha</title>
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
    <!-- CSS -->
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
                        <li><a href="hotels.html">Categories</a></li>
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
                                  <li class="menu-has-children"><a href="">Level 2 </a>
                                    <ul>
                                      <li><a href="#">Item One</a></li>
                                      <li><a href="#">Item Two</a></li>
                                    </ul>
                                  </li>                                      

                            </ul>
                        </li>                               
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header><!-- #header -->
    
    <!-- start banner Area -->
    <section class="about-banner relative">
        <div class="overlay overlay-bg"></div>
        <div class="container">                
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">
                        Tour Packages/Reservation             
                    </h1>    
                    <p class="text-white link-nav"><a href="index.html">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="packages.html"> Tour Packages</a></p>
                </div>    
            </div>
        </div>
    </section>
    
    <!-- Reservation Form Section -->
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <h2 class="text-center mb-4">Reserve for Event</h2>
            <form method="POST" action="addReservation.php" class="border p-4 rounded shadow-sm bg-light">
                <!-- Event Information -->
                <div class="form-group mb-4">
                    <label for="event" class="font-weight-bold">Event</label>
                    <input type="text" id="event" name="event" class="form-control" value="<?= htmlspecialchars($eventName); ?>" readonly>
                    <input type="hidden" name="eventId" value="<?= htmlspecialchars($eventId); ?>">
                    </div>

                <!-- Event Image -->
                <div class="form-group text-center mb-4">
                    <label for="eventImage" class="font-weight-bold">Event Image</label>
                    <div class="d-flex justify-content-center">
                        <!-- Ensure the event image URL is correct and accessible -->
                        <img src="./images/uploads/<?= $eventImage; ?>" alt="Event Image" class="img-fluid rounded shadow-sm" style="max-width: 100%; height: auto; margin-top: 10px;">
                    </div>
                </div>

                <!-- Event Description -->
                <div class="form-group mb-4">
                    <label for="eventDescription" class="font-weight-bold">Event Description</label>
                    <input type="text" id="eventDescription" name="eventDescription" class="form-control" value="<?= htmlspecialchars($eventDesc); ?>" readonly>
                </div>

                <!-- User Information -->
                <div class="form-group mb-4">
                    <label for="name" class="font-weight-bold">Your Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Your Name" required>
                </div>
                <div class="form-group mb-4">
                    <label for="email" class="font-weight-bold">Your Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter Your Email" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4 py-2">Confirm Reservation</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Start footer Area -->
    <footer class="footer-area section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="single-footer-widget">
                        <h6>About Us</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single-footer-widget">
                        <h6>Quick Links</h6>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Packages</a></li>
                            <li><a href="#">Tour</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End footer Area -->
</body>
</html>


