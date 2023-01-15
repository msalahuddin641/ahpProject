<?php
    include 'inc/user.php';
    include 'inc/header.php';
    Session::checkSession();
?>

<?php
    if(isset($_GET['id'])){
        $userId = (int)$_GET['id'];
        $sesId = Session::get("id");
        if($userId != $sesId){
            header("Location: index.php");
        }
    }


    $user = new User();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatePass'])){
        $passUpdate = $user->passUpdateData($userId, $_POST);
    }
?> 

    <!------------profile Form--------------->

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4>Change Password</h4>
                    </div>
                    <div class="col text-right">
                        <a class="btn btn-primary" href="profile.php?id=<?php echo $userId ?>">Back</a>
                    </div>
                </div>
            </div>

     
            <div class="m-3">
<?php
    if(isset($passUpdate)){
        echo $passUpdate;
    }
?>

                <form action="" method="POST" style="max-width:600px">
                    <div class="form-group">
                        <label for="">Old password</label>
                        <input type="password" class="form-control" name="oldPass" id="oldPass" placeholder="Enter your old password here">
                    </div>

                    <div class="form-group">
                        <label for="password">New password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your new password here">
                    </div>
    
                    <button type="submit" name="updatePass" class="btn btn-success">Update</button>
                </form>
            </div>
            
        </div>
    </div>



<?php
    include 'inc/footer.php';
?>