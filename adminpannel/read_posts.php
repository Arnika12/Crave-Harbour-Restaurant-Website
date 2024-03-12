
<?php
    include '../components/connect.php'; 
    
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

   $get_id = $_GET['post_id'];

    // delete post
    if(!isset($_POST['delete'])){
        $p_id =$_POST['product_id'];
        $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);
        $delete_image = $conn->prepare("SELECT * FROM products WHERE id=?");
        $delete_image->execute([$p_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
        if ($fetch_delete_image[' '] != '') {
            unlink('../uploaded_img/'.$fetch_delete_image['image']);
        }

        $delete_post = $conn->prepare("SELECT * FROM products WHERE id=?");
        $delete_post->execute([$p_id]);
        header('location:view_posts.php');
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
        <section class="read-post">
            <h1 class="heading">Your product</h1>
            <div class="box-container">
                <?php
                    $select_post = $conn->prepare("SELECT * FROM products WHERE $id=?");
                    $select_post->execute([$get_id]);
                    if($select_post->rowCount() > 0){
                        while($fetch_post = $select_post->fetch(PDO::FETCH_ASSOC)){
                
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="product_id" value="<?= $fetch_post['$id']; ?>">
                    <div class="status" style="color: <?php if($fetch_post['status'] == 'active'){echo "limegreen";}else{echo "coral";} ?>;">
                            <?=$fetch_post['status']; ?>
                    </div>
                    <?php if($fetch_post['image'] != ''){ ?>
                        <img src="../uploaded_img/<?= $fetch_post['image']; ?>" class="image">
                        <?php } ?>
                        <div class="price">$<?=$fetch_post['price']; ?>/-</div>
                        <div class="title"><?=$fetch_post['title']; ?></div>
                        <div class="content"><?=$fetch_post['product_detail']; ?></div>
                        <div class="flex-btn">
                            <a href="edit_post.php?id=<?= $fetch_post['id'] ?>" class="btn">Edit</a>
                            <button type="submit" name="delete" class="btn" onclick="return confirm('delete this product');"></button>
                            <a href="view_posts.php?post_id=<?= $fetch_post['id'] ?>" class="btn">Go back</a>
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