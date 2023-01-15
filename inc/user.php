<?php 
    include_once 'session.php';
    include 'database.php';


class User{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }

    public function userRegistration($data){
        $name       = $data['name'];
        $username   = $data['username'];
        $email      = $data['email'];
        $password   = $data['password'];
        if(strlen($password)<6){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Password is too short.</div>";
            return $msg;
        }else{
            $password   = md5($password);
        }
        $chk_email  = $this->emailCheck($email);

    

        if($name == "" OR $username == "" OR $email == "" OR $password == ""){
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Filed must not be empty.</div>";
            return $msg;
        }

        if(strlen($username)<5){
            $msg = "<div class='alert alert-danger' role='alert'><strong>Error! </strong>Username is too short.</div>";
            return $msg;
        } elseif (preg_match('/[^a-z0-9_-]+/i', $username)){
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Username must only contain alphanumerical, dashes and underscores.</div>";
            return $msg;
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Email address is not valid.</div>";
            return $msg;
        }

        if($chk_email == true){
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Email address already exist.</div>";
            return $msg;
        }

        $sql = "INSERT INTO tbl_user(name, username, email, password) VALUES(:name, :username, :email, :password)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':name', $name);
        $query->bindValue(':username', $username);
        $query->bindValue(':email', $email);
        $query->bindValue(':password', $password);
        $result = $query->execute();
        if($result){
            $msg = "<div class='alert alert-success role='alert'><strong>Success! </strong>Data inserted successfully.</div>"; 
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Sorry, data insert failed.</div>"; 
            return $msg;
        }

        
    }

    private function emailCheck($email){
        $sql = "SELECT email FROM tbl_user WHERE email = :email";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':email', $email);
        $query->execute();
        if($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function getLoginUser($email, $password){
        $sql = "SELECT * FROM tbl_user WHERE email = :email AND password = :password LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':email', $email);
        $query->bindValue(':password', $password);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }


    public function userLogin($data){
        $email      = $data['email'];
        $password   = $data['password'];
        if(strlen($password)<6){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Password is too short.</div>";
            return $msg;
        }else{
            $password   = md5($password);
        }
        $chk_email  = $this->emailCheck($email);

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Email address is not valid.</div>";
            return $msg;
        }

        if($chk_email == false){
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Email address not exist.</div>";
            return $msg;
        }

        $result = $this->getLoginUser($email, $password);
        if ($result) {
            Session::init();
            Session::set("login", true);
            Session::set("id", $result->id);
            Session::set("name", $result->name);
            Session::set("username", $result->username);
            Session::set("loginmsg", "<div class='alert alert-success role='alert'><strong>Success! </strong>You are logged in.</div>");
            header("Location: index.php");

        }else{
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Login data not found.</div>";
            return $msg;
        }
        
    }

    public function getUserData(){
        $sql = "SELECT * FROM tbl_user ORDER BY id DESC";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function getUserById($id){
        $sql = "SELECT * FROM tbl_user WHERE id= :id LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function userUpdateData($id, $data){
        $name       = $data['name'];
        $username   = $data['username'];
        $email      = $data['email'];
        

        if($name == "" OR $username == "" OR $email == ""){
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Filed must not be empty.</div>";
            return $msg;
        }

        if(strlen($username)<5){
            $msg = "<div class='alert alert-danger' role='alert'><strong>Error! </strong>Username is too short.</div>";
            return $msg;
        } elseif (preg_match('/[^a-z0-9_-]+/i', $username)){
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Username must only contain alphanumerical, dashes and underscores.</div>";
            return $msg;
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Email address is not valid.</div>";
            return $msg;
        }


        $sql = "UPDATE tbl_user SET
                    name        = :name,
                    username    = :username,
                    email       = :email
                    WHERE id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':name', $name);
        $query->bindValue(':username', $username);
        $query->bindValue(':email', $email);
        $query->bindValue(':id', $id);
        $result = $query->execute();
        if($result){
            $msg = "<div class='alert alert-success role='alert'><strong>Success! </strong>Data updated successfully.</div>"; 
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Sorry, data update failed.</div>"; 
            return $msg;
        }
    }

    private function checkPassword($id, $oldPass){
        $password = md5($oldPass);
        $sql = "SELECT email FROM tbl_user WHERE id = :id AND  password = :password";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->bindValue(':password', $password);
        $query->execute();
        if($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function passUpdateData($id, $data){
        $oldPass = $data['oldPass'];
        $newPass = $data['password'];
        $chk_pass = $this->checkPassword($id, $oldPass);
        if($oldPass == "" OR $newPass == ""){
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Filed must not be empty.</div>"; 
            return $msg;
        }
        if($chk_pass == false){
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Old password does not exist.</div>"; 
            return $msg;
        }
        if(strlen($newPass)<6){
            $msg = "<div class='alert alert-danger'><strong>Error! </strong>Password is too short.</div>";
            return $msg;
        }
        
        $password = md5($newPass);
        $sql = "UPDATE tbl_user SET
                    password = :password
                    WHERE id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':password', $password);
        $query->bindValue(':id', $id);
        $result = $query->execute();
        if($result){
            $msg = "<div class='alert alert-success role='alert'><strong>Success! </strong>Password updated successfully.</div>"; 
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger role='alert'><strong>Error! </strong>Sorry, password update failed.</div>"; 
            return $msg;
        }
    }
}

?>