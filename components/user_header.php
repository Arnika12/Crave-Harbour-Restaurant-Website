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
                $select_profile = $conn->prepare("SELECT * FROM users WHERE id=? ");
                $select_profile->execute([$user_id]);
             
                if($select_profile->rowCount() > 0){
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                }
            ?>
            <div class="profile">
                <img src="uploaded_img/<?= $fetch_profile['profile']; ?>">
                <p><?= $fetch_profile['name']; ?></p>
            </div>
            <div class="flex-btn">
                
            </div>
        </div>
    </header>
</div>