
<?php
    include '../components/connect.php'; 
    
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

//    $get_id = $_GET['post_id'];
    if(isset($_POST['save'])) {
        $post_id = $_POST['post_id'];
        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);
        $category = $_POST['category'];
        $category = filter_var($category, FILTER_SANITIZE_STRING);
        $status = $_POST['status'];
        $status = filter_var($status, FILTER_SANITIZE_STRING);

        $update_post = $conn->prepare("UPDATE products  SET name = ?, price = ?, product_detail=?, category=?, status=? WHERE id=?");
        $update_post->execute([$title, $price, $content, $category, $status, $post_id]);

        $success_msg[] = 'product updated !';

        $old_image = $_POST['old_image'];
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_img/'.$image;

        $select_image = $conn->prepare("SELECT * FROM products WHERE image=? AND admin_id=?");
        $select_image->execute([$image, $admin_id]);

        if (!empty($image)) {
            if($image_size > 2000000){
                $warning_msg[] = 'image is too long';
            }elseif($select_image->rowCount() > 0 AND $image != ''){
                $warning_msg[] = 'please rename your image';
            }else{
                $update_image = $conn->prepare("UPDATE products SET image=? WHERE id=?");
                $update_image->execute([$image, $post_id]);
                move_uploaded_file($image_tmp_name, $image_folder);
                if ($old_image != $image AND $old_image != '') {
                    unlink('../uploaded_img/'.$old_image);
                }
                $success_msg[] = 'image updated !';
            }
        }
    }

    // delete product
    if(!isset($_POST['delete_post'])){
        $post_id =$_POST['post_id'];
        $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);
        $delete_image = $conn->prepare("SELECT * FROM products WHERE id=?");
        $delete_image->execute([$post_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
        if ($fetch_delete_image['image'] != '') {
            unlink('../uploaded_img/'.$fetch_delete_image['image']);
        }

        $delete_post = $conn->prepare("DELETE FROM products WHERE id=?");
        $delete_post->execute([$post_id]);
        $success_msg[] = 'product deleted successfully !';
    }

    // delete image
    if(!isset($_POST['delete_image'])){
        $empty_image = '';
        $post_id =$_POST['post_id'];
        $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);
        $delete_image = $conn->prepare("SELECT * FROM products WHERE id=?");
        $delete_image->execute([$post_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
        if ($fetch_delete_image['image'] != '') {
            unlink('../uploaded_img/'.$fetch_delete_image['image']);
        }

        $unset_image = $conn->prepare("UPDATE products SET image=? WHERE id=?");
        $unset_image->execute([$empty_image, $post_id]);
        $success_msg[] = 'image deleted successfully !';
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
    <title>Admin - Edit Product Page</title>
</head>
<body>
    <div class="main-container">
        <?php  include '../components/admin_header.php'; ?>
        <section class="post-editor">
            <h1 class="heading">edit product</h1>
            <div class="box-container">
               <?php
                    $post_id = $_GET['id'];
                    $select_post = $conn->prepare("SELECT * FROM products WHERE id=?");
                    $select_post->execute([$post_id]);
                    if($select_post->rowCount() > 0){
                        while($fetch_post = $select_post->fetch(PDO::FETCH_ASSOC)){

               ?>
               <div class="form-container">
                    <form action="" method="post" enctypee="multipart/form-data">
                        <input type="hidden" name="old_image" value="<?= $fetch_post['image']; ?>">
                        <input type="hidden" name="post_id" value="<?= $fetch_post['id']; ?>">
                        <div class="input-field">
                            <label>post status <sup>*</sup></label>
                            <select name="status">
                                <option value="<?= $fetch_post['status']; ?>" selected></option>
                                <option value="active">active</option>
                                <option value="deactive">deactive</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>product name <sup>*</sup></label>
                            <input type="text" name="title" value="<?= $fetch_post['name']; ?>">
                        </div>
                        <div class="input-field">
                            <label>product price <sup>*</sup></label>
                            <input type="price" name="price" value="<?= $fetch_post['price']; ?>">
                        </div>
                        <div class="input-field">
                            <label>product detail <sup>*</sup></label>
                            <textarea name="content"><?= $fetch_post['product_detail']; ?></textarea>
                        </div>
                        <div class="input-field">
                            <label>product category <sup>*</sup></label>
                            <select name="category" required>
                                <option selected><?= $fetch_post['category']; ?></option>
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
                            <label>post image <sup>*</sup></label>
                            <input type="file" name="image" accept="image/*">
                            <?php if($fetch_post['image'] != ''){ ?>
                                    <img src="../uploaded_img/<?= $fetch_post['image']; ?>" class="image">
                                    <div class="flex-btn">
                                        <input type="submit" name="delete_image" class="btn" value="delete image">
                                        <a href="view_posts.php" class="btn" style="width:49%; text-align:center; height:3rem; margin-top:.7rem;">go back</a>
                                    </div>
                                    
                            <?php } ?>
                        </div>
                        <div class="flex-btn">
                            <input type="submit" name="save" value="save post" class="btn">
                            <input type="submit" name="delete_post" value="delete post" class="btn">
                        </div>
                    </form>
               </div>
               <?php
                     }
                    }else{
                        echo '
                            <div class="empty">
                                <p>no product added yet! <br><a href="add.posts.php" class="btn" style="margin-top:1.5rem;">add product</a></p>
            
                            </div>';
               ?>
               <div class="flex-btn">
                <a href="view_posts.php" class="btn">View Product</a>
                <a href="add_posts.php" class="btn">add product</a>
            </div>
            <?php } ?>
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