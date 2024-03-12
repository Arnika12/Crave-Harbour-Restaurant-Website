<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminpannel/admin_style.css">
    <!-- box icon cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin - Header</title>
</head>
<body>
 
<!-- admin_header.php -->
<div class="head">
    <header>
        <div class="logo">
            <img src="image/logo.png">
        </div>
        <div class="logo1">
            <div class="bx bxs-user" id="user-btn"></div>
            <div class="bx bx-menu" id="menu-btn"></div>
            <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup>0</sup></a>
            <a href="cart.php" class="cart-btn"><i class="bx bx-cart"></i><sup>0</sup></a>
        </div>
        <!-- ------------ profile detail ------------ -->
        <div class="profile-detail">
            <?php
            if (isset($_SESSION['admin_id'])) {
                $admin_id = $_SESSION['admin_id'];
                $select_profile = $conn->prepare("SELECT * FROM admin WHERE id=? ");
                $select_profile->execute([$admin_id]);

                if ($select_profile->rowCount() > 0) {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
                    <div class="profile">
                        <img src="uploaded_img/<?= $fetch_profile['profile']; ?>" class="logo-image">
                        <p><?= $fetch_profile['name']; ?></p>
                    </div>
                    <div class="flex-btn">
                        <a href="update_profile.php" class="btn" style="width:200px;">Update profile</a>
                        <form method="post">
                            <button type="submit" name="logout" class="btn" style="width:150px;">Log out</button>
                        </form>
                    </div>
            <?php
                } else {
            ?>
                    <p class="name">please login or register</p>
                    <div class="flex-btn">
                        <a href="admin_login.php" class="btn">Login</a>
                        <a href="admin_registration.php" class="btn">Register</a>
                    </div>
            <?php
                }
            } else {
            ?>
                <p class="name">please login or register</p>
                <div class="flex-btn">
                    <a href="admin_login.php" class="btn">Login</a>
                    <a href="admin_registration.php" class="btn">Register</a>
                </div>
            <?php
            }
            ?>
        </div>


<div class="side-container">
    <div class="sidebar">
        <?php if(isset($fetch_profile)) { ?>
            <div class="profile">
                <img src="../uploaded_img/<?= $fetch_profile['profile']; ?>" class="logo-img" width="100">
                <p><?= $fetch_profile['name']; ?></p>
            </div>
        <?php } ?>
        <h5>Menu</h5>
        <div class="navbar">
            <ul>
                <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i>Dashboard</a></li>
                <li><a href="add_posts.php"><i class="bx bxs-shopping-bags"></i>Add Products</a></li>
                <li><a href="view_posts.php"><i class="bx bxs-food-menu"></i>View Products</a></li>
                <li><a href="user_accounts.php"><i class="bx bxs-user-detail"></i>Accounts</a></li>
                <li><a href="../components/admin_logout.php" onclick="return confirm('logout from this website')"><i class="bx bx-log-out"></i>Log Out</a></li>
            </ul>
        </div>

        <h5>Find us</h5>
        <div class="social-links">
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-instagram-alt"></i>
            <i class="bx bxl-linkedin"></i>
            <i class="bx bxl-twitter"></i>
            <i class="bx bxl-pinterest-alt"></i>
        </div>
    </div>
</div>
</body>
</html>