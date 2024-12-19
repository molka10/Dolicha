<?php
 // Inclure le fichier config.php
include 'C:\xampp\htdocs\dolichafinalCopy\controllers\EventC.php';
$c = new EventC();
$tab = $c->listEvents();
// Get query parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'date';
$sortOrder = isset($_GET['order']) ? $_GET['order'] : 'ASC';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$eventsPerPage = 4;
$offset = ($page - 1) * $eventsPerPage;

// Fetch the filtered and sorted events
$tab = $c->searchAndSortEvents($offset, $eventsPerPage, $search, $sortColumn, $sortOrder);

// Get total count for pagination
$totalEvents = $c->countEvents($search);
$totalPages = ceil($totalEvents / $eventsPerPage);

// Vérification si un fichier image a été envoyé
if(isset($_FILES['image'])){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    
    $extensions= array("jpeg","jpg","png");
    
    if(in_array($file_ext,$extensions)=== false){
       $errors[]="Extension not allowed, please choose a JPEG or PNG file.";
    }
    
    if($file_size > 2097152){
       $errors[]='File size must be excately 2 MB';
    }
    
    if(empty($errors)==true){
       move_uploaded_file($file_tmp,"../../assets/img/".$file_name);
       echo "Success";
    }else{
       print_r($errors);
    }
 }
?>
	<!DOCTYPE html>
	<html lang="zxx" class="no-js">
	<head>
		<style>
	


		</style>
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
			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="css/linearicons.css">
			<link rel="stylesheet" href="css/font-awesome.min.css">
			<link rel="stylesheet" href="css/bootstrap.css">
			<link rel="stylesheet" href="css/magnific-popup.css">
			<link rel="stylesheet" href="css/jquery-ui.css">				
			<link rel="stylesheet" href="css/nice-select.css">							
			<link rel="stylesheet" href="css/animate.min.css">
			<link rel="stylesheet" href="css/owl.carousel.css">				
			<link rel="stylesheet" href="css/main.css">
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
				          <li><a href="insurance.html">Insurence</a></li>
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
				      </nav><!-- #nav-menu-container -->					      		  
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
								Tour Packages				
							</h1>	
							<p class="text-white link-nav"><a href="index.html">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="packages.html"> Tour Packages</a></p>
						</div>	
					</div>
				</div>
			</section>
			<!-- End banner Area -->	

			<!-- Start hot-deal Area -->
			<section class="hot-deal-area section-gap">
				<div class="container">
		            <div class="row d-flex justify-content-center">
		                <div class="menu-content pb-70 col-lg-8">
		                    <div class="title text-center">
		                        <h1 class="mb-10">Today’s Hot Deals</h1>
		                        <p>We all live in an age that belongs to the young at heart. Life that is becoming extremely fast, day to.</p>
		                    </div>
		                </div>
		            </div>						
					<div class="row justify-content-center">
						<div class="col-lg-10 active-hot-deal-carusel">
							<div class="single-carusel">
								<div class="thumb relative">
									<div class="overlay overlay-bg"></div>
									<img class="img-fluid" src="C:\Users\Houyem\Pictures\dolicha\jem.jpeg" alt="">
								</div>
								<div class="price-detials">
									<a href="#" class="price-btn">Starting From <span>20Dt</span></a>
								</div>
								<div class="details">
									<h4 class="text-white">Ancient Architecture</h4>
									<p class="text-white">
										ELjem
									</p>
								</div>								
							</div>
							<div class="single-carusel">
								<div class="thumb relative">
									<div class="overlay overlay-bg"></div>
									<img class="img-fluid" src="C:\Users\Houyem\Pictures\dolicha\mestirr.jpeg" alt="">
								</div>
								<div class="price-detials">
									<a href="#" class="price-btn">Starting From <span>25Dt</span></a>
								</div>
								<div class="details">
									<h4 class="text-white">Marina of Monastir</h4>
									<p class="text-white">
										Monastir
									</p>
								</div>								
							</div>
							<div class="single-carusel">
								<div class="thumb relative">
									<div class="overlay overlay-bg"></div>
									<img class="img-fluid" src="C:\Users\Houyem\Pictures\dolicha\frig.jpg" alt="">
								</div>
								<div class="price-detials">
									<a href="#" class="price-btn">Starting From <span>15Dt</span></a>
								</div>
								<div class="details">
									<h4 class="text-white">Zoo</h4>
									<p class="text-white">
										Friguia park,bouficha
									</p>
								</div>								
							</div>														
						</div>
					</div>
				</div>	
			</section>
			<!-- End hot-deal Area -->
			

			<!-- Start destinations Area -->
			<section class="destinations-area section-gap">
				<div class="container">
		            <div class="row d-flex justify-content-center">
		                <div class="menu-content pb-40 col-lg-8">
		                    <div class="title text-center">
		                        <h1 class="mb-10">Popular Destinations</h1>
		                        <p>We all live in an age that belongs to the young at heart. Life that is becoming extremely fast, day to.</p>
		                    </div>
		                </div>
		            </div>						
					
			
					<div class="search-sort-container">
    <!-- Search Bar -->
    <form method="GET" action="" class="form-inline search-form">
        <div class="input-group">
            <input 
                type="text" 
                class="form-control" 
                name="search" 
                placeholder="Search events..." 
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
            >
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
        
        <!-- Sort Dropdown -->
        <div class="dropdown sort-dropdown">
            <button 
                class="btn btn-secondary dropdown-toggle" 
                type="button" 
                id="sortMenuButton" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
                Sort by: <?= isset($_GET['sort']) && $_GET['sort'] === 'prix' ? ($_GET['order'] === 'DESC' ? 'Price: High to Low' : 'Price: Low to High') : 'Date' ?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="sortMenuButton">
                <li>
                    <a 
                        class="dropdown-item" 
                        href="?search=<?= urlencode($_GET['search'] ?? '') ?>&sort=prix&order=ASC">
                        Price: Low to High
                    </a>
                </li>
                <li>
                    <a 
                        class="dropdown-item" 
                        href="?search=<?= urlencode($_GET['search'] ?? '') ?>&sort=prix&order=DESC">
                        Price: High to Low
                    </a>
                </li>
                <li>
                    <a 
                        class="dropdown-item" 
                        href="?search=<?= urlencode($_GET['search'] ?? '') ?>&sort=date&order=ASC">
                        Date (Oldest)
                    </a>
                </li>
                <li>
                    <a 
                        class="dropdown-item" 
                        href="?search=<?= urlencode($_GET['search'] ?? '') ?>&sort=date&order=DESC">
                        Date (Newest)
                    </a>
                </li>
            </ul>
        </div>
    </form>
</div>
</div>

			<!-- Start home-about Area -->
<!-- Start home-about Area -->
<section class="ftco-section ftco-no-pt">
    <div class="container">
        <div class="row event-container">
            <?php foreach ($tab as $event): ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="single-destination card">
                    <!-- Dynamic image -->
                    <div class="thumb card-image">
                        <img class="thumb_img" src="./images/uploads/<?= $event['image']; ?>" alt="<?= $event['nom']; ?>">
                    </div>
                    <div class="details card-content">
                        <h4 class="event-title"><?= $event['nom']; ?></h4>
                        <p class="event-location"><?= $event['lieu']; ?></p>
                        <ul class="package-list">
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Duration</span>
                                <span><?= $event['duration']; ?> Days</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Date</span>
                                <span><?= $event['date']; ?></span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Price per person</span>
                                <a href="#" class="price-btn"><?= $event['prix']; ?> Dt</a>
                            </li>
                        </ul>
                        <a href="../front_office/addReservation.php?eventId=<?= $event['id']; ?>&eventName=<?= urlencode($event['nom']); ?>&eventDesc=<?= urlencode($event['description']); ?>" 
                           class="btn btn-primary mt-2 reserve-button">
                            Reserve Now
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


	

    </div>
</div>

	
</section>
<div class="pagination-container">
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i; ?>&search=<?= urlencode($_GET['search'] ?? ''); ?>&sort=<?= $_GET['sort'] ?? 'date'; ?>&order=<?= $_GET['order'] ?? 'ASC'; ?>">
                        <?= $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>



			<!-- End home-about Area -->

			<!-- start footer Area -->		
			<footer class="footer-area section-gap">
				<div class="container">

					<div class="row">
						<div class="col-lg-3  col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>About Agency</h6>
								<p>
									The world has become so fast paced that people don’t want to stand by reading a page of information, they would much rather look at a presentation and understand the message. It has come to a point 
								</p>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>Navigation Links</h6>
								<div class="row">
									<div class="col">
										<ul>
											<li><a href="#">Home</a></li>
											<li><a href="#">Feature</a></li>
											<li><a href="#">Services</a></li>
											<li><a href="#">Portfolio</a></li>
										</ul>
									</div>
									<div class="col">
										<ul>
											<li><a href="#">Team</a></li>
											<li><a href="#">Pricing</a></li>
											<li><a href="#">Blog</a></li>
											<li><a href="#">Contact</a></li>
										</ul>
									</div>										
								</div>							
							</div>
						</div>							
						<div class="col-lg-3  col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>Newsletter</h6>
								<p>
									For business professionals caught between high OEM price and mediocre print and graphic output.									
								</p>								
								<div id="mc_embed_signup">
									<form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscription relative">
										<div class="input-group d-flex flex-row">
											<input name="EMAIL" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address '" required="" type="email">
											<button class="btn bb-btn"><span class="lnr lnr-location"></span></button>		
										</div>									
										<div class="mt-10 info"></div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-lg-3  col-md-6 col-sm-6">
							<div class="single-footer-widget mail-chimp">
								<h6 class="mb-20">InstaFeed</h6>
								<ul class="instafeed d-flex flex-wrap">
									<li><img src="img/i1.jpg" alt=""></li>
									<li><img src="img/i2.jpg" alt=""></li>
									<li><img src="img/i3.jpg" alt=""></li>
									<li><img src="img/i4.jpg" alt=""></li>
									<li><img src="img/i5.jpg" alt=""></li>
									<li><img src="img/i6.jpg" alt=""></li>
									<li><img src="img/i7.jpg" alt=""></li>
									<li><img src="img/i8.jpg" alt=""></li>
								</ul>
							</div>
						</div>						
					</div>

					<div class="row footer-bottom d-flex justify-content-between align-items-center">
						<p class="col-lg-8 col-sm-12 footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
						<div class="col-lg-4 col-sm-12 footer-social">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-behance"></i></a>
						</div>
					</div>
				</div>
			</footer>
			<!-- End footer Area -->	
<script>
	function filterEvents() {
    const query = document.getElementById("searchBar").value.toLowerCase();
    const events = document.querySelectorAll(".single-destinations");
    events.forEach(event => {
        const eventName = event.querySelector("h4").textContent.toLowerCase();
        const eventLocation = event.querySelector("p").textContent.toLowerCase();
        event.style.display = eventName.includes(query) || eventLocation.includes(query) ? "" : "none";
    });
}

</script>
<script>
	function sortEvents() {
    const sortOption = document.getElementById("sortOptions").value;
    const eventsContainer = document.querySelector(".row");
    const events = Array.from(eventsContainer.children);

    events.sort((a, b) => {
        const aValue = a.querySelector(`.details ul li:contains(${sortOption})`).textContent.split(" ").pop();
        const bValue = b.querySelector(`.details ul li:contains(${sortOption})`).textContent.split(" ").pop();
        return sortOption === "price" || sortOption === "duration" ? aValue - bValue : new Date(aValue) - new Date(bValue);
    });

    events.forEach(event => eventsContainer.appendChild(event));
}

</script>
			<script src="js/vendor/jquery-2.2.4.min.js"></script>
			<script src="js/popper.min.js"></script>
			<script src="js/vendor/bootstrap.min.js"></script>			
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>		
 			<script src="js/jquery-ui.js"></script>					
  			<script src="js/easing.min.js"></script>			
			<script src="js/hoverIntent.js"></script>
			<script src="js/superfish.min.js"></script>	
			<script src="js/jquery.ajaxchimp.min.js"></script>
			<script src="js/jquery.magnific-popup.min.js"></script>						
			<script src="js/jquery.nice-select.min.js"></script>					
			<script src="js/owl.carousel.min.js"></script>							
			<script src="js/mail-script.js"></script>	
			<script src="js/main.js"></script>	
		</body>
	</html>