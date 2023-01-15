<?php
    include 'inc/user.php';
    include 'inc/header.php';
    Session::checkSession();
?>


<div class="container">
    <?php
        $loginmsg = session::get("loginmsg");
        if(isset($loginmsg)){
            echo $loginmsg;
        }
        Session::set("loginmsg", NULL);
    ?>
</div>


    <!------------Table--------------->
    
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h4>User List</h4>
            </div>
            <div class="col text-right">
                <h4>Welcome! <strong>
                    <?php
                        $name = Session::get("name");
                        if(isset($name)){
                            echo $name;
                        }
                    ?>
                </strong></h4>
            </div>
        </div>

        <table class="table table-hover border">
            <thead>
                <tr>
                    <th scope="col">Serial</th>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

<?php
    $user = new User();
    $userdata = $user->getUserData();
    if($userdata){
        $i = 0;
        foreach($userdata as $sdata){
            $i++;

?>
                <tr>
                    <th scope="row"><?php echo $i; ?></th>
                    <td><?php echo $sdata['name']; ?></td>
                    <td><?php echo $sdata['username']; ?></td>
                    <td><?php echo $sdata['email']; ?></td>
                    <td>
                        <a class="btn btn-success" href="profile.php?id=<?php echo $sdata['id']; ?>">View</a>
                    </td>
                </tr>
                
<?php } }else{ ?>  
    <tr><td colspan="5"><h2>No User Data found!</h2></td></tr>
<?php } ?>
            </tbody>
        </table>
    </div>






<?php
    include 'inc/footer.php';
?>

