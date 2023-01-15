<?php
    include 'inc/user.php';
    include 'inc/header.php';
    Session::checkSession();
?>

<?php
    if(isset($_GET['id'])){
        $userId = (int)$_GET['id'];
    }

    $user = new User();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
        $userUpdate = $user->userUpdateData($userId, $_POST);
    }
?> 

    <!------------profile Form--------------->

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4>Your Profile</h4>
                    </div>
                    <div class="col text-right">
                        <a class="btn btn-primary" href="index.php">Back</a>
                    </div>
                </div>
            </div>


     
            <div class="m-3">
<?php
    if(isset($userUpdate)){
        echo $userUpdate;
    }
?>
<?php
    $userdata = $user->getUserById($userId);
    if($userdata){
?>  
                <form action="" method="POST" style="max-width:600px">
                    <div class="form-group">
                        <label for="name">Your name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name here" value="<?php echo $userdata->name; ?>">
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username here" value="<?php echo $userdata->username; ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email here" value="<?php echo $userdata->email; ?>">
                    </div>
                <?php 
                    $sesId = Session::get("id");
                    if($userId == $sesId){
                ?>
                    <button type="submit" name="update" class="btn btn-success">Update</button>
                    <a class="btn btn-primary" href="changepass.php?id=<?php echo $userId ?>">Change Password</a>
                    <?php } ?>
                </form>
<?php } ?>
            </div>
            
        </div>
    </div>



<?php
    include 'inc/footer.php';
?>