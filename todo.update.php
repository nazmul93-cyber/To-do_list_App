<?php

   //connecting to database

   if (isset($_GET['user_id'])) {

        $user_in = $_GET['user_id'];
   }

   if (isset($_POST['update']) && !empty($_POST['task'])) {

        $task_in = $_POST['task'];
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

    class UI extends Connection{
                
        public $user_prop;
        public $id;
        public $task_prop;
        

        public function updateDB($user_param,$task_param) {
            $this->user_prop = $user_param;
            $this->task_prop = $task_param;

            //update
            if (isset($_GET['up_task']) && !empty($_POST['task'])) {
                $this->id = $_GET['up_task'];

                $dbUpdate = $this->pdo->prepare("UPDATE tasks SET task=:task WHERE id=:id");
                $dbUpdate->bindParam(':task',$this->task_prop,PDO::PARAM_STR);
                $dbUpdate->bindParam(':id',$this->id,PDO::PARAM_INT);
                $dbUpdate->execute();
                header("location: todo.php?user_id=$this->user_prop");
            }
        }
    }

    $ui = new UI('mysql','todo');
    $ui->updateDB($user_in,$task_in);

?>

 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Update list</title>
</head>
<body>

    <div class="heading">
    
        <h3>Update todo :</h3>
    </div>


    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">

        <input type="text" name="task" id="" class="task_inp">

        <button type="submit" name="update" class="task_btn">Update Task</button>

    </form>



</body>
</html>


