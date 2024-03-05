
<?php
    include '../components/connect.php'; 
    
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    //add product to database
    if(!isset($_POST['publish'])){
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
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_tmp_name = $_FILES['image']['tmp_name'];
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
                }
        }else{
            $image = '';
        }
        if($select_image->rowCount() > 0 AND $image != ''){
            $warning_msg[] = 'please rename your image !';
        }else{
            $insert_post = $conn->prepare("INSERT INTO products(id,name,price,image,category,product_detail,status) VALUES(?,?,?,?,?,?,?)");
            $insert_post->execute([$id, $name, $price, $image, $category, $content, $status]);
            $success_msg[] = 'product inserted successfully !';
        }
    }

    //save draft product to database
    if(!isset($_POST['draft'])){
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
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_tmp_name = $_FILES['image']['tmp_name'];
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
                }
        }else{
            $image = '';
        }
        if($select_image->rowCount() > 0 AND $image != ''){
            $warning_msg[] = 'please rename your image !';
        }else{
            $insert_post = $conn->prepare("INSERT INTO products(id,name,price,image,category,product_detail,status) VALUES(?,?,?,?,?,?,?)");
            $insert_post->execute([$id, $name, $price, $image, $category, $content, $status]);
            $success_msg[] = 'product sace as draft !';
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
        <section class="show-post">
            <h1 class="heading">Your product</h1>
            <div class="box-container">
                <?php
                    $select_post = $conn->prepare("SELECT * FROM products");
                    $select_post->execute();
                    if($select_post->rowCount() > 0){
                        while($fetch_post = $select_post->fetch(PDO::FETCH_ASSOC)){
                
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="product_id" value="<?= $fetch_post['$id']; ?>">
                    <?php if($fetch_post['image'] != ''){ ?>
                        <img src="../uploaded_img/<?= $fetch_post['image']; ?>" class="image">
                        <?php } ?>
                        <div class="status" style="color: <?php if($fetch_post['status'] == 'active'){echo "limegreen";}else{echo "coral";} ?>;">
                            <?=$fetch_post['status']; ?>
                        </div>
                        <div class="price">$<?=$fetch_post['price']; ?>/-</div>
                        <div class="title"><?=$fetch_post['title']; ?></div>
                        <div class="flex-btn">
                            <a href="edit_post.php?id=<?= $fetch_post['id'] ?>" class="btn">Edit</a>
                            <button type="submit" name="delete" class="btn" onclick="return confirm('delete this product');"></button>
                            <a href="read_posts.php?post_id=<?= $fetch_post['id'] ?>" class="btn">View post</a>
                        </div>
                </form>
                <?php
                        }
                    }else{
                        echo '
                        <div class="empty">
                            <p>no product added yet! <br> <a href="add_posts.php" class="btn" style="margin-top:1.5rem;">add product</a></p>
                        </div>
                        ';
                    } 
                ?>
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