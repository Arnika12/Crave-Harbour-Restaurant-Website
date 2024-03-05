
<?php  
    session_start();

    include '../components/connect.php'; 

    // session_start();

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    
        $select_admin = $conn->prepare("SELECT * FROM admin WHERE name=? AND password=?");
        $select_admin->execute([$name, $pass]);
    
        if($select_admin->rowCount() > 0){
            $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
            $_SESSION['admin_id'] = $fetch_admin_id['id'];
            header('location:dashboard.php');
        }
        else{
            $warning_msg[] = 'Incorrect username or password!';
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
                    <h3>Login Now</h3>
                    <div class="input-field">
                        <label>User Name <sup>*</sup></label>
                        <input type="text" name="name" maxlength="20" required placeholder="Enter User Name" 
                            oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-field">
                        <label>User Password <sup>*</sup></label>
                        <input type="password" name="pass" maxlength="20" required placeholder="Enter User Password" 
                            oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <input type="submit" name="submit" value="Login now" class="btn">
                    <p><i class='bx bx-user-plus'></i><a href="admin_register.php">Register Admin</a></p>
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