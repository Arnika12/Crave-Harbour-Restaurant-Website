
<?php
    include 'components/connect.php'; 
    session_start();

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user-id'];
    }else{
        $user_id = '';
    }
?>

<style type="text/css">
    <?php  include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- box icon cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
    <title>Crave Harbour - Home Page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <!-- hero slider start -->
    <div class="slider-container">
        <div class="slider">
        <!--  slide start -->
            <div class="slideBox active" >
                <div class="textBox" >
                    <h1>extra spicy pizza</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. </p>
                    <div class="flex-btn" >
                        <a href="menu.php" class="btn">view menu</a>
                        <a href="menu.php" class="btn">order now</a>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="image/slider-1.png">
                </div>
            </div>
             <!--  slide end -->

            <!-- slide start -->
            <div class="slideBox" >
                <div class="textBox" >
                    <h1>test something unique</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. </p>
                    <div class="flex-btn" >
                        <a href="menu.php" class="btn">view menu</a>
                        <a href="menu.php" class="btn">order now</a>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="image/slider-2.png">
                </div>
            </div>
             <!--  slide end -->

            <!--  slide start -->
            <div class="slideBox" >
                <div class="textBox" >
                    <h1>extra spicy pizza</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. </p>
                    <div class="flex-btn" >
                        <a href="menu.php" class="btn">view menu</a>
                        <a href="menu.php" class="btn">order now</a>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="image/slider-3.png">
                </div>
            </div>
             <!--  slide end -->

            <!--  slide start -->
            <div class="slideBox" >
                <div class="textBox" >
                    <h1>extra spicy pizza</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. </p>
                    <div class="flex-btn" >
                        <a href="menu.php" class="btn">view menu</a>
                        <a href="menu.php" class="btn">order now</a>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="image/slider-4.png">
                </div>
            </div>
             <!--  slide end -->
        </div>
        <div class="controls">
            <li onclick="nextSlide();"><i class="bx bx-right-arrow-alt"></i></li>
            <li onclick="prevSlide();"><i class="bx bx-left-arrow-alt"></i></li>
        </div>
    </div>
    <!--  hero slide start -->
    <!--  category section -->
    <div class="category" >
                <div class="title" >
                    <h1>top categories</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. </p>
                </div>
                <div class="box-container">
                    <div class="box">
                        <div class="img-box">
                            <img src="image/food1.jpg">
                        </div>
                        <p> What's hot</p>
                    </div>
                    <div class="box">
                        <div class="img-box">
                            <img src="image/food1.jpg">
                        </div>
                        <p> Burger </p>
                    </div>
                    <div class="box">
                        <div class="img-box">
                            <img src="image/food2.jpg">
                        </div>
                        <p> Chicken and Salad</p>
                    </div>
                    <div class="box">
                        <div class="img-box">
                            <img src="image/food4.jpg">
                        </div>
                        <p> breakfast </p>
                    </div>
                    <div class="box">
                        <div class="img-box">
                            <img src="image/food5.jpg">
                        </div>
                        <p> Dinner </p>
                    </div>
                    <div class="box">
                        <div class="img-box">
                            <img src="image/food6.png">
                        </div>
                        <p> Desert </p>
                    </div>
                </div>
    </div>

    <!-- ----- product section ---- -->
    <section class="products">
        <div class="title">
            <h1>top categories</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque vel nostrum minima. Nemo rem laborum enim alias, eaque et ea fugiat cumque sunt atque assumenda blanditiis voluptate optio quae necessitatibus?</p>
        </div>
        <?php include 'components/shop.php'; ?>
    </section>

    <!--  container section -->
    <div class="container">
        <div class="box-container">
            <div class="box">
                <img src="image/client.png">
            </div>
            <div class="box">
                <span>Healthy food</span>
                <h1>save up to 50% off</h1>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Modi, quidem cum repellat id dolores non minus doloribus consectetur vitae dolor a vel amet voluptatum. In omnis molestias doloribus expedita quas.</p>
                <div class="flex-btn">
                    <a href="menu.php" class="btn">visit our menu</a>
                </div>
            </div>
        </div>
    </div>
    <div class="client">
        <div class="box-container">
            <div class="box">
                <img src="image/shef1.png">
            </div>
            <div class="box">
                <img src="image/shef2.png">
            </div>
            <div class="box">
                <img src="image/shef3.png">
            </div>
            <div class="box">
                <img src="image/shef4.png">
            </div>
            <div class="box">
                <img src="image/shef5.png">
            </div>
            <div class="box">
                <img src="image/shef6.png">
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

    <?php include 'components/dark.php'; ?>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- custom js link -->
    <script type="text/javascript" src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>