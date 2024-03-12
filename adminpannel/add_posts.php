<?php
    include '../components/connect.php'; 
    
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    // Function to generate unique ID
    function unique_id(){
        return uniqid();
    }

    // Add product to database
    if(isset($_POST['publish'])){
        $id = unique_id();
        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);

        $category = $_POST['category'];
        $category = filter_var($category, FILTER_SANITIZE_STRING);
        $status = 'active';

        $image = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_folder = '../uploaded_img/'.$image;

        $select_image = $conn->prepare("SELECT * FROM products WHERE image=? AND admin_id=?");
        $select_image->execute([$image, $admin_id]);

        if (isset($image)) {
            if($select_image->rowCount() > 0){
                $warning_msg[] = 'Image name repeated !';
            }
            elseif($image_size > 2000000){
                $warning_msg[] = 'image size is too large !';
            }
            else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $insert_post = $conn->prepare("INSERT INTO products(id,name,price,image,category,product_detail,status,admin_id) VALUES(?,?,?,?,?,?,?,?)");
                $insert_post->execute([$id, $title, $price, $image, $category, $content, $status, $admin_id]);
                $success_msg[] = 'product inserted successfully !';
            }
        } else {
            $image = '';
        }
    }

    // Save draft product to database
    if(isset($_POST['draft'])){
        $id = unique_id();
        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);

        $category = $_POST['category'];
        $category = filter_var($category, FILTER_SANITIZE_STRING);
        $status = 'deactive';

        $image = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_folder = '../uploaded_img/'.$image;

        $select_image = $conn->prepare("SELECT * FROM products WHERE image=? AND admin_id=?");
        $select_image->execute([$image, $admin_id]);

        if (isset($image)) {
            if($select_image->rowCount() > 0){
                $warning_msg[] = 'Image name repeated !';
            }
            elseif($image_size > 2000000){
                $warning_msg[] = 'image size is too large !';
            }
            else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $insert_post = $conn->prepare("INSERT INTO products(id,name,price,image,category,product_detail,status,admin_id) VALUES(?,?,?,?,?,?,?,?)");
                $insert_post->execute([$id, $title, $price, $image, $category, $content, $status, $admin_id]);
                $success_msg[] = 'product saved as draft !';
            }
        } else {
            $image = '';
        }
    }
?>

<style type="text/css">
    <?php  include 'admin_style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- box icon cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin - Add Product Page</title>
</head>
<body>
    <div class="main-container">
        <?php  include '../components/admin_header.php'; ?>
        <section class="post-editor">
            <h1 class="heading">Add product</h1>
           <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
            <div class="input-field">
                <label>product name <sup>*</sup></label>
                <input type="text" name="title" maxlength="100" placeholder="add product title" required>
            </div>
            <div class="input-field">
                <label>product price <sup>*</sup></label>
                <input type="number" name="price" maxlength="100" placeholder="add product price" required>
            </div>
            <div class="input-field">
                <label>product detail <sup>*</sup></label>
                <textarea name="content" required maxlength="10000" placeholder="product detail"></textarea>
            </div>
            <div class="input-field">
                <label>product category <sup>*</sup></label>
                <select name="category" required>
                    <option selected disabled>-----select category -----</option>
                    <option value="what's hot">what's hot</option>
                    <option value="burgers">burgers</option>
                    <option value="chicken and salads">chicken and salads</option>
                    <option value="tacos, fries adn sides">tacos, fries adn sides</option>
                    <option value="breakfast">breakfast</option>
                    <option value="family dinner">family dinner</option>
                    <option value="shakes and desserts">shakes and desserts</option>
                </select>
            </div>
            <div class="input-field">
                <label>product image <sup>*</sup></label>
                <input type="file" name="image" accept="image/*" required>
            </div>
            <div class="flex-btn">
                <input type="submit" name="publish" value="publish now" class="btn">
                <input type="submit" name="draft" value="save draft" class="btn">
            </div>
            </form>
           </div>
        </section>
    </div>

    <?php include '../components/dark.php'; ?>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- custom js link -->
    <script type="text/javascript" src="script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
