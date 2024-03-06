
<?php
    include '../components/connect.php'; 
    
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    // update order payment
    if(isset($_POST['update_order'])){
        $order_id = $_POST['order_id'];
        $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

        $update_payment = $_POST['update_payment'];
        $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);

        $update_pay = $conn->prepare("UPDATE orders SET payment_status=? WHERE id=?");
        $update_pay->execute([$update_payment, $order_id]);
        $success_msg[] = 'order payment status updated ! ';
    }
    
    // delete order details
    if(!isset($_POST['delete_order'])){
        $delete_id =$_POST['order_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_delete = $conn->prepare("SELECT * FROM orders WHERE id=?");
        $verify_delete->execute([$delete_id]);

        if ($verify_delete->rowCount > 0) {
            $delete_message = $conn->prepare("SELECT * FROM orders WHERE id=?");
            $delete_message->execute([$delete_id]);
            $success_msg[] = 'order deleted successfully';
        }else{
            $warning_msg[] = 'order already deleted';
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
    <title>Admin - order place Page</title>
</head>
<body>
    <div class="main-container">
        <?php  include '../components/admin_header.php'; ?>
        <section class="order-container>
            <h1 class="heading"> total orders placed </h1>
            <div class="box-container">
                <?php
                    $select_order = $conn->prepare("SELECT * FROM orders");
                    $select_order->execute();
                    if($select_order->rowCount() > 0){
                        while($fetch_order = $select_order->fetch(PDO:FETCH_ASSOC)){
                ?>
                <div class="box">
                    <div class="status" style="color: <?php if($fetch_order['status'] == 'in progress'){echo "limegreen";}else{echo "coral";} ?>">
                            <?= $fetch_order['status']; ?>
                    </div>
                    <div class="detail">
                        <p>user name : <span><?php $fetch_order['name']; ?></span></p>
                        <p>user id : <span><?php $fetch_order['user_id']; ?></span></p>
                        <p>plcaed on : <span><?php $fetch_order['date']; ?></span></p>
                        <p>number : <span><?php $fetch_order['number']; ?></span></p>
                        <p> total price : <span><?php $fetch_order['price']; ?></span></p>
                        <p>payment method : <span><?php $fetch_order['method']; ?></span></p>
                        <p> address : <span><?php $fetch_order['address ']; ?></span></p>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
                        <select name="update_payment">
                            <option disabled selected><?php echo $fetch_order['payment_status']; ?></option>
                            <option value="pending">Pending</option>
                            <option value="complete">Complete</option>
                        </select>
                        <div class="flex-btn">
                            <input type="submit" name="update_order" value="update payment" class="btn">
                            <input type="submit" name="delete_order" value="delete order" class="btn" onclick="return confirm('delete this order');">
                        </div>
                    </form>
                </div>
                <?php
                        }
                        }else{
                            echo '
                            <div class="empty">
                                <p> no order take place yet! </p>
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