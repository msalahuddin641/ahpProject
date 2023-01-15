<?php
    include 'inc/header.php';
    include 'inc/user.php';
    $user = new User();
?>
<?php
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
        $userReg = $user->userRegistration($_POST);
    }
?>

    <!------------Registration Form--------------->

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>User Registration</h4>
            </div>
            <div class="m-3">
<?php
    if(isset($userReg)){
        echo $userReg;
    }
?>
                <form action="" method="POST" style="max-width:600px">
                    <div class="form-group">
                        <label for="name">Your name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name here">
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username here">
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email here">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <button type="submit" name="register" class="btn btn-success">Register</button>
                </form>

            </div>
            
        </div>
    </div>



<?php
    include 'inc/footer.php';
?>