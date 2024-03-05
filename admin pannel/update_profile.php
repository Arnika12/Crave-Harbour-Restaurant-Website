
<?php  
    include '../components/connect.php'; 

    session_start();
    $admin_id = $SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }
    if(!isset($_POST['submit'])){
        //update name
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        if (!empty($name)) {
            $select_name = $conn->prepare("SELECT * FROM admin WHERE name=?");
            $select_name->execute([$name]);

            if($select_name->rowCount() > 0){
                $warning_msg[] = 'username already exist';
            }
            else{
                $update_name = $conn->prepare("UPDATE admin SET name = ? WHERE id=?");
                $update_name->execute([$name, $admin_id]);
                $success_msg[] = 'Name Updated Successfully !';
            }
        }

        //update email
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        if (!empty($email)) {
            $select_email = $conn->prepare("SELECT * FROM admin WHERE email=?");
            $select_email->execute([$email]);

            if($select_email->rowCount() > 0){
                $warning_msg[] = 'username already exist';
            }
            else{
                $update_email = $conn->prepare("UPDATE admin SET email = ? WHERE id=?");
                $update_email->execute([$email, $admin_id]);
                $success_msg[] = 'Email Updated Successfully !';
            }
        }

        //update image
        $old_image = $_POST['lod_image'];
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_img/'.$image;

        $update_image = $conn->prepare("UPDATE admin SET profile = ? WHERE id=?");
        $update_image->execute(['$image', $admin_id]);
        move_uploaded_file($image_tmp_name, $image_folder);
        if($old_image != $image AND $old_image != ''){
            unlink('../uploaded_img/'.$image);
        }
        $success_msg[] = 'Image Updated Successfully !';

        //update password
        $empty_pass = 'da23er452cwfef3453cerr56ve464ghf';
        $select_old_pass = $conn->prepare("SELECT password FROM admin WHERE id=?");
        $select_old_pass->execute([$admin_id]);

        $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
        $prev_pass = $fetch_prev_pass['password'];

        $old_pass = sha1($_POST['old_pass']);
        $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);

        $new_pass = sha1($_POST['new_pass']);
        $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

        $cpass = sha1($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        if($old_pass != $empty_pass){
            if($old_pass != $prev_pass){
                $warning_msg[] = 'old password not matched';
            }elseif($new_pass != $cpass){
                $warning_msg[] = 'confirm password not matched';
            }else{
                if ($new_pass != $empty_pass){
                    $update_pass = $conn->prepare("UPDATE admin SET password=? WHERE id=?");
                    $update_pass->execute($cpass, $admin_id);
                    $success_msg[] = 'Password Updated Successfully !';
                }
                else{
                    $warning_msg[] = 'please enter a new password';
                }
            }
        }
        
    }
?>

<style>
    <?php  include 'admin_style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- box icon cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin - Registration Page </title>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section>
            <div class="form-container" id="admin-login">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="profile">
                        <img src="../uploaded_img/<?= $fetch_profile['profile']; ?>" class="logo-img">
                    </div>
                    <h3>Update Profile</h3>
                    <input type="hidden" name="old_image" value="<?= $fetch_profile['profile']; ?>">
                    <div class="input-field">
                        <label>User Name <sup>*</sup></label>
                        <input type="text" name="name" maxlength="20" placeholder="Enter User Name" 
                            oninput="this.value.replace(/\s/g,'')" value="<?= $fetch_profile['name']; ?>">
                    </div>
                    <div class="input-field">
                        <label>User Email <sup>*</sup></label>
                        <input type="email" name="email" maxlength="25" placeholder="Enter User Email" 
                            oninput="this.value.replace(/\s/g,'')" value="<?= $fetch_profile['email']; ?>">
                    </div>
                    <div class="input-field">
                        <label>User Password <sup>*</sup></label>
                        <input type="password" name="pass" maxlength="20" placeholder="Enter User Password" 
                            oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-field">
                        <label>Old Password <sup>*</sup></label>
                        <input type="password" name="old_pass" maxlength="20" placeholder="Confirm Your Password" 
                            oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-field">
                        <label>New Password <sup>*</sup></label>
                        <input type="password" name="new_pass" maxlength="20" placeholder="Confirm Your Password" 
                            oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-field">
                        <label>Upload profile <sup>*</sup></label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <input type="submit" name="submit" value="Update Profile" class="btn">
                </form>
            </div>
        </section>
    </div>
    <?php include '../components/dark.php'; ?>
</body>
</html>