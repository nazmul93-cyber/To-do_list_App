<?php

    if (isset($_POST['log'])){

        if(!empty($_POST['email']) && !empty($_POST['pass'])) {

            $email_in = $_POST['email'];
            $pass_in = $_POST['pass'];
        
        }

        elseif(empty($_POST['email']) || empty($_POST['pass'])) {

            echo "<p style='color:red;'>    Did not log in !!! please insert all inputs correctly   </p>";
        }
            
    }


    class Connection {

        public $pdo;

        public function __construct($dbms,$dbnm) {

                try{

                    $this->pdo = new PDO("$dbms:dbname=$dbnm;host=localhost","root","test");    
                    // echo "SUCCESS !!! connection established";                
                }catch(PDOException $e) {
                    
                    die("CONNECTION FAILED!!!");
                }
        }
    }


    class User extends Connection {
            public $id;
            public $email;
            public $pass;

            public function loginCheck($email,$pass) {
                
                $this->email = $email;
                $this->pass = $pass;
                
                $dbQuery = $this->pdo->prepare("SELECT password FROM user WHERE email=:email");
                $dbQuery->bindParam(':email', $email, PDO::PARAM_STR);
                $dbQuery->execute();


                while($row = $dbQuery->fetch(PDO::FETCH_ASSOC)){

                    if ($row['password'] == $pass) {
                        
                        $dbQuery = $this->pdo->prepare("SELECT id FROM user WHERE email=:email");
                        $dbQuery->bindParam(':email', $email, PDO::PARAM_STR);
                        $dbQuery->execute();
                        
                        while($row = $dbQuery->fetch(PDO::FETCH_ASSOC)){

                            $row_id = $row['id'];
                            header("location: todo.php?user_id=$row_id");
                        }

                    }else {
                        echo "<p style='color:red'> Password did not match !!! plaese try again </p>";
                    }
                }
            }
    }

    $user = new User('mysql','todo');
    $user->loginCheck($email_in,$pass_in);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login todo</title>
</head>
<body>
    
    <p>Please login below :</p>

    <form action="" method="POST">
    
        <input type="email" name="email" id="" placeholder="Email"> <br />
        <input type="password" name="pass" id="" placeholder="Password"> <br />

        <input type="submit" name="log" value="Log In">
    </form>

    
  
</body>
</html>