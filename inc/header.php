<?php
    include_once 'session.php';
    Session::init();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AHP project</title>
    
    <link rel="stylesheet" href="lib/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<?php
IF(isset($_GET['action']) && $_GET['action'] == "logout"){
    Session::destroy();
}
?>


<body>

    <!------------Menu--------------->
    
    <div class="container bg-light rounded">
        <nav class="navbar navbar-expand-lg navbar-light bg-light p-4">
            <a class="navbar-brand ms-3 text-success" href="index.php"><strong>AHP</strong> PROJECT</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end ms-3 me-3" id="navbarNav">
                <ul class="navbar-nav">
                    <?php
                        $id = Session::get("id");
                        $userlogin = Session::get("login");
                        if($userlogin == true){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php?id=<?php echo $id; ?>">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?action=logout">Logout</a>
                    </li>
                    <?php }else{ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>