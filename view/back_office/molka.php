<?php
require_once '../../config.php'; // Include Database class
require_once '../../controller/userController.php'; // Include user controller functions
session_start(); // Démarre la session

$db = (new Database())->getConnection();

ob_end_clean();
$variable = getUserById($db, $_SESSION['user']['id']);
$role = $variable['userRole'];
if ($role == 'user') {
  header('Location: ../front_office/index.php');
  exit;
}

// Récupérer la valeur de recherche (si présente)
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Récupérer les utilisateurs (en incluant le critère de recherche si présent)
$users = getAllUsers($db, $search);
?>

<!DOCTYPE html>
  <head>
    <style>
      .pagination {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

.pagination-button {
    padding: 5px 10px;
    margin: 0 5px;
    border: 1px solid #ddd;
    background-color: #f8f9fa;
    cursor: pointer;
}

.pagination-button.active {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.pagination-button:hover {
    background-color: #e2e6ea;
}

    </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dolicha</title>
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
  <bod>
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
              <a class="nav-link" href="molka.php">
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
              <a class="nav-link" href="pages/forms/basic_elements.php">
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

            
            

        <!-- Table Section -->
       


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
                    
                    </div>
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
                <a href="view/front_office/login.html" class="nav-link"><i class="mdi mdi-logout menu-icon"></i>
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
              <h2 class="text-dark font-weight-bold mb-2"> Overview dashboard </h2>
              <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
                
                <div class="btn-group bg-white p-3" role="group" aria-label="Basic example">
                  

            <div class="d-xl-flex justify-content-between align-items-start">
            <div class="card">
            <h4>User List</h4>

      

        <!-- Barre de recherche -->
        <div style="text-align: center; margin-bottom: 20px;">
            <input type="text" id="searchInput" placeholder="Rechercher un utilisateur..." style="width: 80%; padding: 10px; font-size: 16px; border: 1px solid #ddd;">
        </div>

        <div class="filter-container">
    <label for="roleFilter">Filtrer par rôle :</label>
    <select id="roleFilter">
        <option value="all">Tous</option>
        <option value="User">User</option>
        <option value="Admin">Admin</option>
        <option value="Vendeur">Vendeur</option>
    </select>
</div>

<div class="table-responsive">
    <table class="table" id="userTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
                <th>Address</th>
                <th>Nationality</th>
                <th>Date of Birth</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr data-role="<?= htmlspecialchars($user['userRole']) ?>">
                    <td><?= htmlspecialchars($user['id_user']) ?></td>
                    <td data-name="<?= htmlspecialchars($user['nom']) ?>"><?= htmlspecialchars($user['nom']) ?></td>
                    <td><?= htmlspecialchars($user['prenom']) ?></td>
                    <td><?= htmlspecialchars($user['usermail']) ?></td>
                    <td><?= '********' ?></td>
                    <td><?= htmlspecialchars($user['userRole']) ?></td>
                    <td><?= htmlspecialchars($user['adress']) ?></td>
                    <td><?= htmlspecialchars($user['Nationalite']) ?></td>
                    <td><?= htmlspecialchars($user['ddn']) ?></td>
                    <td><?= htmlspecialchars($user['num']) ?></td>
                    <td>
                        <form method="POST" action="../../controller/userController.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>

                        <form method="POST" action="/dolicha/view/front_office/signup.php" style="display:">
                            <input type="hidden" name="action" value="add">
                            <button type="submit" class="btn btn-success">Add User</button>
                        </form>

                        <form method="GET" action="/dolicha/view/back_office/pages/forms/basic_elements.php" style="display:inline;">
                            <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                            <button type="submit" class="btn btn-warning">Edit</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div id="pagination" class="pagination"></div>
</div>


<!-- JavaScript pour la recherche dynamique -->
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#userTable tbody tr');

        rows.forEach(row => {
            const nom = row.querySelector('td[data-name]').textContent.toLowerCase();
            if (nom.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    document.getElementById('roleFilter').addEventListener('change', function() {
    const selectedRole = this.value.toLowerCase();
    const rows = document.querySelectorAll('#userTable tbody tr');

    rows.forEach(row => {
        const role = row.getAttribute('data-role').toLowerCase();
        if (selectedRole === 'all' || role === selectedRole) {
            row.style.display = ''; // Affiche la ligne
        } else {
            row.style.display = 'none'; // Cache la ligne
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const rowsPerPage = 5; // Nombre de lignes par page
    const table = document.getElementById('userTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const pagination = document.getElementById('pagination');

    function displayPage(pageNumber) {
        const start = (pageNumber - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach((row, index) => {
            row.style.display = index >= start && index < end ? '' : 'none';
        });
    }

    function createPaginationButtons(totalRows, rowsPerPage) {
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        pagination.innerHTML = ''; // Réinitialise les boutons

        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.classList.add('pagination-button');
            button.addEventListener('click', () => {
                displayPage(i);
                setActiveButton(i);
            });
            pagination.appendChild(button);
        }

        // Afficher la première page au chargement
        if (totalPages > 0) {
            displayPage(1);
            setActiveButton(1);
        }
    }

    function setActiveButton(activePage) {
        const buttons = pagination.querySelectorAll('.pagination-button');
        buttons.forEach(button => {
            button.classList.toggle('active', button.textContent == activePage);
        });
    }

    // Initialisation
    createPaginationButtons(rows.length, rowsPerPage);
});

</script>

            
            
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
  </body>
</html>