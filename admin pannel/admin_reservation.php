
<?php
    include '../components/connect.php'; 
    
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    //update booking
    if(isset($_POST['update_obooking'])){
        $booking_id = $_POST['booking_id'];
        $booking_id = filter_var($booking_id, FILTER_SANITIZE_STRING);

        $confirm_booking = $_POST['confirm_booking'];
        $confirm_booking = filter_var($confirm_booking, FILTER_SANITIZE_STRING);

        $update_booking = $conn->prepare("UPDATE reservation SET confirmation=? WHERE id=?");
        $update_booking->execute([$confirm_booking, $booking_id]);
        $success_msg[] = 'booking updated ! ';
    }
    
    // delete order details
    if(!isset($_POST['delete_booking'])){
        $delete_id =$_POST['booking_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_delete = $conn->prepare("SELECT * FROM reservation WHERE id=?");
        $verify_delete->execute([$delete_id]);

        if ($verify_delete->rowCount > 0) {
            $delete_booking = $conn->prepare("SELECT * FROM reservation WHERE id=?");
            $delete_booking->execute([$delete_id]);
            $success_msg[] = 'reservation successfully';
        }else{
            $warning_msg[] = 'reservation already deleted';
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
    <title>Admin - unread message Page</title>
</head>
<body>
    <div class="main-container">
        <?php  include '../components/admin_header.php'; ?>
        <section class="message-container>
            <h1 class="heading"> user's reservation </h1>
            <div class="box-container">
                <?php
                    $select_reservation = $conn->prepare("SELECT * FROM reservation");
                    $select_reservation->execute();
                    if ($select_reservation->rowCount() > 0) {
                        while($fetch_reservation = $select_reservation->fetch(PDO::FETCH_ASSOC));{

                ?>
                <div class="box">
                        <p class="name"><?php $fetch_reservation['name']; ?></p>
                        <p><span>user email<?php $fetch_reservation['email']; ?></span></p>
                        <p><span>user number<?php $fetch_reservation['number']; ?></span></p>
                        <p><span>total person<?php $fetch_reservation['select_one']; ?></span></p>
                        <p><span>date<?php $fetch_reservation['date']; ?></span></p>
                        <p><span>time<?php $fetch_reservation['time']; ?></span></p>
                        <p><span>comment<?php $fetch_reservation['comment']; ?></span></p>
            
                    <form action="" method="post">
                        <input type="hidden" name="booking_id" value="<?= $fetch_reservation['id']; ?>">
                        <select name="confirm_booking">
                            <option selected disabled><?php echo $fetch_reservation['confirmation']; ?></option>
                            <option value="pending">Pending</option>
                            <option value="complete">Complete</option>
                        </select>
                        <div class="flex-btn">
                            <input type="submit" name="update_booking" value="update booking" class="btn">
                            <input type="submit" name="delete_booking" value="delete booking" class="btn" onclick="return confirm('delete this booking'); >
                        </div>
                    </form>
                </div>
                <?php
                    }
                    }else{
                        echo '
                        <div class="empty">
                            <p> no reservation yet! </p>
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