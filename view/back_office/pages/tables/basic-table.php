<?php
require_once '../../../../config.php'; // Include Database class
require_once '../../../../controller/userController.php'; // Include user controller functions

// Initialize the database connection
$db = (new Database())->getConnection();

// Fetch all users
$users = getAllUsers($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="view\back_office\dashboard.html"> <!-- Replace with actual path -->
    
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f5fa;
        }

        .container-scroller {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background-color: #27293d;
            color: #ffffff;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar h1 {
            text-align: center;
            padding: 20px;
            margin: 0;
            font-size: 1.5rem;
            background-color: #2b2d42;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
            font-size: 1rem;
            color: #cfd4e0;
            cursor: pointer;
        }

        .sidebar ul li:hover {
            background-color: #4b49ac;
            color: #ffffff;
        }

        .content-wrapper {
            flex: 1;
            padding: 20px;
            background-color: #ffffff;
            overflow: auto;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f4f5fa;
        }

        .navbar .profile-info {
            display: flex;
            align-items: center;
        }

        .navbar .profile-info img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        /* Card & Table */
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .card h4 {
            font-size: 1.2rem;
            color: #4B49AC;
            margin-bottom: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f4f5fa;
            font-weight: bold;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .btn-danger {
            background-color: #ff5c5c;
            color: white;
        }

        .btn-warning {
            background-color: #ffa426;
            color: white;
        }

        .btn-primary {
            background-color: #4B49AC;
            color: white;
        }

        .btn-primary:hover {
            background-color: #3A3E99;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <!-- Sidebar -->
        <nav class="sidebar">
            <h1>dolicha</h1>
            <ul>
                <li><a href="../../../../../dashboard.html"></a> Dashboard</li>
                <li>Forms</li>
                <li>Charts</li>
                <li>USER</li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="content-wrapper">
            <!-- Navbar -->
            <nav class="navbar">
                <div>
                    <input type="text" placeholder="Search products" style="padding: 8px 10px; border-radius: 4px; border: 1px solid #ddd;">
                </div>
                <div class="profile-info">
                    <img src="D:\xampp\htdocs\dolicha\view\back_office\assets\images\faces\face1.jpg" alt="Profile Picture"> <!-- Replace with actual image path -->
                    <span>Henry Klein</span>
                </div>
            </nav>

           

            <!-- Table Section -->
            <div class="card">
                <h4>User List</h4>
                <?php if (!empty($users)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
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
                                    <tr>
                                        <td><?= htmlspecialchars($user['id_user']) ?></td>
                                        <td><?= htmlspecialchars($user['usermail']) ?></td>
                                        <td><?= htmlspecialchars($user['userRole']) ?></td>
                                        <td><?= htmlspecialchars($user['adress']) ?></td>
                                        <td><?= htmlspecialchars($user['Nationalite']) ?></td>
                                        <td><?= htmlspecialchars($user['ddn']) ?></td>
                                        <td><?= htmlspecialchars($user['num']) ?></td>
                                        <td>
                                            <form method="POST" action="../../../../controller/userController.php" style="display:inline;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                            <form method="POST" action="../../../../view/front_office/signup.html" style="display:inline;">
    <input type="hidden" name="action" value="add">
    <button type="submit" class="btn btn-success">Add User</button>
 </form>

                                            <form method="GET" action="edit_user.php" style="display:inline;">
                                                <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                                <button type="submit" class="btn btn-warning">Edit</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>No users found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
