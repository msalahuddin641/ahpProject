<?php
    include 'inc/header.php';
    include 'inc/user.php';
    Session::checklogin();
?>
<?php
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
        $userLog = $user->userLogin($_POST);
    }
?>

    <!------------Login Form--------------->

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>User login</h4>
            </div>
            <div class="m-3">

<?php
if(isset($userLog)){
echo $userLog;
}
?>
                <form action="" method="POST" style="max-width:600px">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email here">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <button type="submit" name="login" class="btn btn-success">Login</button>
                </form>
            </div>
            
        </div>
    </div>



<?php
    include 'inc/footer.php';
?>