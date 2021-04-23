<?php


if (isset($_POST['reg'])){

    if(!empty($_POST['email']) && !empty($_POST['pass'])) {

        $email_in = $_POST['email'];
        $pass_in = $_POST['pass'];
    
    }

    elseif(empty($_POST['email']) || empty($_POST['pass'])) {

        echo "<p style='color:red;'>    Not registered !!! please insert all inputs correctly   </p>";
    }
        
}



class Connection {

    public $pdo;

    public function __construct($dbms,$dbnm) {

        try{

            $this->pdo = new PDO("$dbms:dbname=$dbnm;host=localhost", "root","test");
            // echo "CONNECTION ESTABLISHED";

        }catch(PDOException $e) {

            die("NO CONNECTION !!! PLEASE CHECK CONNECTION");
        }
    }
}

// $conn = new Connection('mysql','todo');

class User extends Connection {

    public $email;
    public $pass;

    public function insertDB($email,$pass) {
        $this->email = $email;
        $this->pass = $pass;

        $dbQuery = $this->pdo->prepare('INSERT INTO user(email, password) VALUES(:email, :password)');

        $dbQuery->bindParam(':email', $email, PDO::PARAM_STR);
        $dbQuery->bindParam(':password', $pass, PDO::PARAM_STR);
        $result = $dbQuery->execute();                // $result only checks if its executed or not
        
        if($result){
            header('location: login.php');
        }
    }
}

$user = new User('mysql', 'todo');

$user->insertDB($email_in, $pass_in);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register todo</title>
</head>
<body>
    
    <p>please register below :</p>

    <form action="" method="POST">
    
        <input type="email" name="email" id="" placeholder="Email"> <br />
        <input type="password" name="pass" id="" placeholder="Password"> <br />

        <input type="submit" name="reg" value="Register">
    </form>

    <p>If you are already reagistered, please goto <a href="login.php">login</a> </p>
  
</body>
</html>

