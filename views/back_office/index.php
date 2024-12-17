<?php
// Include necessary files
require_once 'comandeController.php';
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
<html lang="en">
  <head>
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
    </style>
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
}</style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Connect Plus</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="index.html"><img src="assets/images/logo.svg" alt="logo" /></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <div class="search-field d-none d-xl-block">
            <form class="d-flex align-items-center h-100" action="#">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" placeholder="Search products">
              </div>
            </form>
          </div>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item  dropdown d-none d-md-block">
              <a class="nav-link dropdown-toggle" id="reportDropdown" href="#" data-toggle="dropdown" aria-expanded="false"> Reports </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="reportDropdown">
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-file-pdf mr-2"></i>PDF </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-file-excel mr-2"></i>Excel </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-file-word mr-2"></i>doc </a>
              </div>
            </li>
            <li class="nav-item  dropdown d-none d-md-block">
              <a class="nav-link dropdown-toggle" id="projectDropdown" href="#" data-toggle="dropdown" aria-expanded="false"> Projects </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="projectDropdown">
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-eye-outline mr-2"></i>View Project </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-pencil-outline mr-2"></i>Edit Project </a>
              </div>
            </li>
            <li class="nav-item nav-language dropdown d-none d-md-block">
              <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="nav-language-icon">
                  <i class="flag-icon flag-icon-us" title="us" id="us"></i>
                </div>
                <div class="nav-language-text">
                  <p class="mb-1 text-black">English</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                <a class="dropdown-item" href="#">
                  <div class="nav-language-icon mr-2">
                    <i class="flag-icon flag-icon-ae" title="ae" id="ae"></i>
                  </div>
                  <div class="nav-language-text">
                    <p class="mb-1 text-black">Arabic</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <div class="nav-language-icon mr-2">
                    <i class="flag-icon flag-icon-gb" title="GB" id="gb"></i>
                  </div>
                  <div class="nav-language-text">
                    <p class="mb-1 text-black">English</p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="assets/images/faces/face28.png" alt="image">
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black">Henry Klein</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                <div class="p-3 text-center bg-primary">
                  <img class="img-avatar img-avatar48 img-avatar-thumb" src="assets/images/faces/face28.png" alt="">
                </div>
                <div class="p-2">
                  <h5 class="dropdown-header text-uppercase pl-2 text-dark">User Options</h5>
                  <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                    <span>Inbox</span>
                    <span class="p-0">
                      <span class="badge badge-primary">3</span>
                      <i class="mdi mdi-email-open-outline ml-1"></i>
                    </span>
                  </a>
                  <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                    <span>Profile</span>
                    <span class="p-0">
                      <span class="badge badge-success">1</span>
                      <i class="mdi mdi-account-outline ml-1"></i>
                    </span>
                  </a>
                  <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="javascript:void(0)">
                    <span>Settings</span>
                    <i class="mdi mdi-settings"></i>
                  </a>
                  <div role="separator" class="dropdown-divider"></div>
                  <h5 class="dropdown-header text-uppercase  pl-2 text-dark mt-2">Actions</h5>
                  <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                    <span>Lock Account</span>
                    <i class="mdi mdi-lock ml-1"></i>
                  </a>
                  <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                    <span>Log Out</span>
                    <i class="mdi mdi-logout ml-1"></i>
                  </a>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-email-outline"></i>
                <span class="count-symbol bg-success"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                <h6 class="p-3 mb-0 bg-primary text-white py-4">Messages</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="assets/images/faces/face4.jpg" alt="image" class="profile-pic">
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
                    <p class="text-gray mb-0"> 1 Minutes ago </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="assets/images/faces/face2.jpg" alt="image" class="profile-pic">
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
                    <p class="text-gray mb-0"> 15 Minutes ago </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="assets/images/faces/face3.jpg" alt="image" class="profile-pic">
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
                    <p class="text-gray mb-0"> 18 Minutes ago </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <h6 class="p-3 mb-0 text-center">4 new messages</h6>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="mdi mdi-bell-outline"></i>
                <span class="count-symbol bg-danger"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <h6 class="p-3 mb-0 bg-primary text-white py-4">Notifications</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="mdi mdi-calendar"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                    <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="mdi mdi-settings"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                    <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                      <i class="mdi mdi-link-variant"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                    <p class="text-gray ellipsis mb-0"> New admin wow! </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <h6 class="p-3 mb-0 text-center">See all notifications</h6>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                <span class="menu-title">UI Elements</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/icons/mdi.html">
                <span class="icon-bg"><i class="mdi mdi-contacts menu-icon"></i></span>
                <span class="menu-title">Icons</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/forms/basic_elements.html">
                <span class="icon-bg"><i class="mdi mdi-format-list-bulleted menu-icon"></i></span>
                <span class="menu-title">Forms</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/charts/chartjs.html">
                <span class="icon-bg"><i class="mdi mdi-chart-bar menu-icon"></i></span>
                <span class="menu-title">Charts</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/tables/basic-table.html">
                <span class="icon-bg"><i class="mdi mdi-table-large menu-icon"></i></span>
                <span class="menu-title">Tables</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="icon-bg"><i class="mdi mdi-lock menu-icon"></i></span>
                <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item documentation-link">
              <a class="nav-link" href="http://www.bootstrapdash.com/demo/connect-plus-free/jquery/documentation/documentation.html" target="_blank">
                <span class="icon-bg">
                  <i class="mdi mdi-file-document-box menu-icon"></i>
                </span>
                <span class="menu-title">Documentation</span>
              </a>
            </li>
            <li class="nav-item sidebar-user-actions">
              <div class="user-details">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <div class="d-flex align-items-center">
                      <div class="sidebar-profile-img">
                        <img src="assets/images/faces/face28.png" alt="image">
                      </div>
                      <div class="sidebar-profile-text">
                        <p class="mb-1">Henry Klein</p>
                      </div>
                    </div>
                  </div>
                  <div class="badge badge-danger">3</div>
                </div>
              </div>
            </li>
            <li class="nav-item sidebar-user-actions">
              <div class="sidebar-user-menu">
                <a href="#" class="nav-link"><i class="mdi mdi-settings menu-icon"></i>
                  <span class="menu-title">Settings</span>
                </a>
              </div>
            </li>
            <li class="nav-item sidebar-user-actions">
              <div class="sidebar-user-menu">
                <a href="#" class="nav-link"><i class="mdi mdi-speedometer menu-icon"></i>
                  <span class="menu-title">Take Tour</span></a>
              </div>
            </li>
            <li class="nav-item sidebar-user-actions">
              <div class="sidebar-user-menu">
                <a href="#" class="nav-link"><i class="mdi mdi-logout menu-icon"></i>
                  <span class="menu-title">Log Out</span></a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row" id="proBanner">
              <div class="col-12">
                <span class="d-flex align-items-center purchase-popup">
                  <p>Like what you see? Check out our premium version for more.</p>
                  <a href="https://github.com/BootstrapDash/ConnectPlusAdmin-Free-Bootstrap-Admin-Template" target="_blank" class="btn ml-auto download-button">Download Free Version</a>
                  <a href="http://www.bootstrapdash.com/demo/connect-plus/jquery/template/" target="_blank" class="btn purchase-button">Upgrade To Pro</a>
                  <i class="mdi mdi-close" id="bannerClose"></i>
                </span>
              </div>
            </div>
            <div class="d-xl-flex justify-content-between align-items-start">
              
              <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
                
                <div class="dropdown ml-0 ml-md-4 mt-2 mt-lg-0">
                  <button class="btn bg-white dropdown-toggle p-3 d-flex align-items-center" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-calendar mr-1"></i>24 Mar 2019 - 24 Mar 2019 </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                    <h6 class="dropdown-header">Settings</h6>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="d-sm-flex justify-content-between align-items-center transaparent-tab-border {">
                  <ul class="nav nav-tabs tab-transparent" role="tablist">
                    
                    <li class="nav-item">
                      <a class="nav-link active" id="business-tab" data-toggle="tab" href="#business-1" role="tab" aria-selected="false">Tous les commandes</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" id="business2-tab" data-toggle="tab" href="#business-2" role="tab" aria-selected="false">Ajouter un coupon</a>
                    </li>
                    
                  </ul>
                  <div class="d-md-block d-none">
                    <a href="#" class="text-light p-1"><i class="mdi mdi-view-dashboard"></i></a>
                    <a href="#" class="text-light p-1"><i class="mdi mdi-dots-vertical"></i></a>
                  </div>
                </div>
                <div class="tab-content tab-transparent-content">
                  <div class="tab-pane fade show active" id="business-2" role="tabpanel" aria-labelledby="business2-tab">
                    <div class="row">
                      <div class="">
                         <body>
                          <style>
                                  /* Container for the coupon form */
                                  .coupon-form-container {
                                      width: 100%;
                                      max-width: 500px;
                                      margin: 0 auto;
                                      padding: 20px;
                                      background-color: #f4f4f4;
                                      border-radius: 8px;
                                      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                  }

                                  /* Style for the form */
                                  .coupon-form {
                                      display: flex;
                                      flex-direction: column;
                                  }

                                  /* Form group to style each label and input pair */
                                  .form-group {
                                      margin-bottom: 15px;
                                  }

                                  .form-group label {
                                      font-size: 16px;
                                      font-weight: bold;
                                      margin-bottom: 5px;
                                  }

                                  .form-group input, .form-group select {
                                      width: 100%;
                                      padding: 10px;
                                      font-size: 16px;
                                      border: 1px solid #ccc;
                                      border-radius: 4px;
                                  }

                                  /* Style for submit button */
                                  .submit-btn {
                                      background-color: #4CAF50;
                                      color: white;
                                      padding: 12px 20px;
                                      font-size: 18px;
                                      border: none;
                                      border-radius: 4px;
                                      cursor: pointer;
                                      transition: background-color 0.3s ease;
                                  }

                                  /* Hover effect for the submit button */
                                  .submit-btn:hover {
                                      background-color: #45a049;
                                  }

                                  /* Optional responsive design: make form responsive for smaller screens */
                                  @media (max-width: 600px) {
                                      .coupon-form-container {
                                          width: 100%;
                                          padding: 10px;
                                      }

                                      .coupon-form {
                                          padding: 0;
                                      }
                                  }

                          </style>
                          <header>
                              <h1>Ajouter un Coupon</h1>
                          </header>

                          <!-- Coupon Form -->
                          <div class="coupon-form-container">
                          <form id="couponForm" action="add_coupon.php" method="POST" class="coupon-form">
                                      <div class="form-group">
                                          <label for="couponCode">Code du Coupon:</label>
                                          <input type="text" id="couponCode" name="coupon_code" placeholder="Entrez le code du coupon">
                                      </div>

                                      <div class="form-group">
                                          <label for="discount">Montant de la Réduction (%):</label>
                                          <input type="text" id="discount" name="discount" placeholder="Montant de la réduction">
                                      </div>

                                      <div class="form-group">
                                          <label for="expiryDate">Date d'Expiration:</label>
                                          <input type="date" id="expiryDate" name="expiry_date">
                                      </div>

                                      <div class="form-group">
                                          <label for="status">Statut:</label>
                                          <select id="status" name="status">
                                              <option value="1">Actif</option>
                                              <option value="0">Inactif</option>
                                          </select>
                                      </div>

                                      <div class="form-actions">
                                          <button type="submit" class="submit-btn">Ajouter le Coupon</button>
                                      </div>
                                  </form>

                          </div>
                              <script>
                              // Wait for the DOM to load
                              document.addEventListener('DOMContentLoaded', function () {

                                  // Get the form
                                  const form = document.getElementById('couponForm');

                                  // Handle form submission
                                  form.addEventListener('submit', function (event) {
                                      // Prevent form submission until validation is done
                                      event.preventDefault();

                                      // Get form input values
                                      const couponCode = document.getElementById('couponCode').value.trim();
                                      const discount = document.getElementById('discount').value.trim();
                                      const expiryDate = document.getElementById('expiryDate').value.trim();
                                      const status = document.getElementById('status').value;

                                      // Validate Coupon Code: It should not be empty
                                      if (couponCode === "") {
                                          alert("Le code du coupon est requis.");
                                          return;
                                      }

                                      // Validate Discount: It should be a valid number and non-negative
                                      if (discount === "" || isNaN(discount) || parseFloat(discount) <= 0) {
                                          alert("Veuillez entrer un montant de réduction valide.");
                                          return;
                                      }

                                      // Validate Expiry Date: It should not be empty
                                      if (expiryDate === "") {
                                          alert("La date d'expiration est requise.");
                                          return;
                                      }

                                      // Validate Status: It should be either 0 or 1 (active or inactive)
                                      if (status !== "0" && status !== "1") {
                                          alert("Le statut du coupon est invalide.");
                                          return;
                                      }

                                      // If all validations pass, submit the form
                                      form.submit(); // If no errors, submit the form
                                  });
                              });
                          </script>

                      </body>

                          
                      </div>
                      <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
        
                      </div>
                      <div class="col-xl-3  col-lg-6 col-sm-6 grid-margin stretch-card">
                        
                      </div>
                      <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        
                      </div>
                    </div>
                    
                    
                  </div>
                </div>
                <div class="tab-content tab-transparent-content">
                  <div class="tab-pane fade show active" id="business-3" role="tabpanel" aria-labelledby="business3-tab">
                    <div class="row">
                      <div class="">
                      <?php
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

$action = $_GET['action'] ?? null; // Check action (edit, delete)
$id = $_GET['id'] ?? null; // Get coupon ID from URL
$error = null;

// Handle form submission for updating a coupon
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_coupon'])) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $discount = $_POST['discount'];
    $expiryDate = $_POST['expiryDate'];

    try {
        $stmt = $pdo->prepare("UPDATE coupon SET code = :code, discount = :discount, expiryDate = :expiryDate WHERE id = :id");
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':discount', $discount);
        $stmt->bindParam(':expiryDate', $expiryDate);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        $error = "Update Error: " . $e->getMessage();
    }
}

// Handle delete request
if ($action === 'delete' && $id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM coupon WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        $error = "Delete Error: " . $e->getMessage();
    }
}

// Fetch all coupons for display
try {
    $stmt = $pdo->query("SELECT * FROM coupon");
    $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Fetch Error: " . $e->getMessage());
}

// Fetch coupon for editing
if ($action === 'edit' && $id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM coupon WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$coupon) {
            die("Coupon not found.");
        }
    } catch (PDOException $e) {
        die("Fetch Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Coupons</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            color: white;
        }
        .edit-btn {
            background-color: #007bff;
        }
        .edit-btn:hover {
            background-color: #0056b3;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .cancel-btn {
            background-color: #6c757d;
        }
        .cancel-btn:hover {
            background-color: #5a6268;
        }
        .save-btn {
            background-color: #28a745;
        }
        .save-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Manage Coupons</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($action === 'edit' && isset($coupon)): ?>
        <h2>Edit Coupon</h2>
        <form action="index.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($coupon['id']) ?>">
            <label for="code">Code:</label>
            <input type="text" id="code" name="code" value="<?= htmlspecialchars($coupon['code']) ?>" required>
            <br>
            <label for="discount">Discount (%):</label>
            <input type="number" id="discount" name="discount" value="<?= htmlspecialchars($coupon['discount']) ?>" required>
            <br>
            <label for="expiryDate">Expiry Date:</label>
            <input type="date" id="expiryDate" name="expiryDate" value="<?= htmlspecialchars($coupon['expiryDate']) ?>" required>
            <br>
            <button type="submit" name="update_coupon" class="save-btn">Save</button>
            <button type="button" onclick="window.location.href='index.php'" class="cancel-btn">Cancel</button>
        </form>
    <?php else: ?>
        <h2>Coupons List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Discount (%)</th>
                    <th>Expiry Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($coupons as $coupon): ?>
                    <tr>
                        <td><?= htmlspecialchars($coupon['id']) ?></td>
                        <td><?= htmlspecialchars($coupon['code']) ?></td>
                        <td><?= htmlspecialchars($coupon['discount']) ?></td>
                        <td><?= htmlspecialchars($coupon['expiryDate']) ?></td>
                        <td>
                            <a href="index.php?action=edit&id=<?= $coupon['id'] ?>" class="edit-btn">Edit</a>
                            <a href="index.php?action=delete&id=<?= $coupon['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>



                          
                      </div>
                      <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
        
                      </div>
                      <div class="col-xl-3  col-lg-6 col-sm-6 grid-margin stretch-card">
                        
                      </div>
                      <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        
                      </div>
                    </div>
                    
                    
                  </div>
                </div>
                <div class="tab-content tab-transparent-content">
                  <div class="tab-pane fade show active" id="business-1" role="tabpanel" aria-labelledby="business-tab">
                    <div class="row">
                      <div class="">
                            <!-- Search Bar -->
<label for="search">Search by Nom Client:</label>
<input type="text" id="search" onkeyup="filterTable()" placeholder="Type to search..."><br><br>

<!-- Table to display the order information -->
<table id="orderTable">
    <thead>
        <tr>
            <th>ID Commande</th>
            <th>ID User</th>
            <th>Nom Client</th>
            <th>ID Panier</th>
            <th>Date</th>
            <th>Status</th>
            <th onclick="sortTable(5)">Total &#x25B2;&#x25BC;</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($commandes as $commande): ?>
            <tr>
                <td data-label="ID Commande"><?php echo htmlspecialchars($commande['idcommande']); ?></td>
                <td data-label="ID User"><?php echo htmlspecialchars($commande['iduser']); ?></td>
                <td data-label="Nom Client"><?php echo htmlspecialchars($commande['nom_client']); ?></td>
                <td data-label="ID Panier"><?php echo htmlspecialchars($commande['Idpanier']); ?></td>
                <td data-label="Date">
                    <?php 
                    // Format the date
                    $date = new DateTime($commande['date']);
                    echo htmlspecialchars($date->format('d/m/y')); // Output as d/m/y
                    ?>
                </td>
                <td data-label="Status">
                    <?php echo htmlspecialchars($commande['status'] == 1 ? 'Confirmed' : 'Not Confirmed'); ?>
                </td>
                <td data-label="Total"><?php echo htmlspecialchars($commande['total']); ?></td>
                <td data-label="Actions" class="action-links">
                    <a href="delete_commande.php?id=<?php echo $commande['idcommande']; ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                    
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
                          
                      </div>
                      <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
        
                      </div>
                      <div class="col-xl-3  col-lg-6 col-sm-6 grid-margin stretch-card">
                        
                      </div>
                      <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        
                      </div>
                    </div>
                    
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="footer-inner-wraper">
              <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard templates</a> from Bootstrapdash.com</span>
              </div>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/jquery-circle-progress/js/circle-progress.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->

    <script>
function filterTable() {
    // Get the input value and convert it to lowercase
    const input = document.getElementById('search');
    const filter = input.value.toLowerCase();
    
    // Get the table and its rows
    const table = document.getElementById('orderTable');
    const rows = table.getElementsByTagName('tr');

    // Loop through all table rows, and hide those that don't match the search query
    for (let i = 1; i < rows.length; i++) { // Start at 1 to skip the header row
        const cells = rows[i].getElementsByTagName('td');
        let found = false;

        // Loop through each cell in the row
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell) {
                const textValue = cell.textContent || cell.innerText;
                if (textValue.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break; // Stop checking if a match is found
                }
            }
        }

        // Show or hide the row based on the search
        rows[i].style.display = found ? "" : "none"; // Show if found, hide if not
    }
}

function sortTable(columnIndex) {
    const table = document.getElementById("orderTable");
    const tbody = table.tBodies[0];
    const rows = Array.from(tbody.rows);
    const isAscending = table.getAttribute('data-sort-order') === 'asc';

    rows.sort((a, b) => {
        let aText = a.cells[columnIndex]?.textContent.trim() || "";
        let bText = b.cells[columnIndex]?.textContent.trim() || "";

        if (columnIndex === 0 || columnIndex === 5) { // Assuming columns 0 and 5 contain numeric values
            aText = parseFloat(aText.replace('€', '').replace(',', '.')) || 0;
            bText = parseFloat(bText.replace('€', '').replace(',', '.')) || 0;
        } else if (columnIndex === 3) { // Assuming column 3 contains dates
            aText = new Date(aText);
            bText = new Date(bText);
        }

        return isAscending ? aText > bText ? 1 : -1 : aText < bText ? 1 : -1;
    });

    rows.forEach(row => tbody.appendChild(row)); // Append rows in sorted order
    table.setAttribute('data-sort-order', isAscending ? 'desc' : 'asc'); // Toggle sort order
}

</script>
  </body>
</html>