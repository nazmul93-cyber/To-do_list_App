<?php

    if(isset($_POST['add'])) {

        $task_in = $_POST['task'];
    }

    if (isset($_GET['user_id'])) {

        $user_in = $_GET['user_id'];
    }

    // setting up connection :
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


class User extends Connection {

    public $task_prop;
    public $user_prop;

    public function insertDB($task_param,$user_param) {

        $this->task_prop = $task_param;
        $this->user_prop = $user_param;
    
        // insertion :
        if (isset($_POST['add']) && !empty($_POST['task'])) {

            $dbQuery = $this->pdo->prepare('INSERT INTO tasks(task, user_id) VALUES(:task, :userid)');

            $dbQuery->bindParam(':task', $this->task_prop, PDO::PARAM_STR);
            $dbQuery->bindParam(':userid', $this->user_prop, PDO::PARAM_STR);
            $dbQuery->execute();  
        }
        

    }

}

$user = new User('mysql', 'todo');

$user->insertDB($task_in,$user_in);
// $user->selectDB($user_in);



    


// deletion 

    // if(isset($_GET['del_task'])){

    //     $id = $_GET['del_task'];

    //     $deleteQuery = "DELETE FROM tasks WHERE id=?";
    //     $dlt = $conn->prepare($deleteQuery);
    //     $dlt->execute([$id]);
    //     header('location: todo.php');
    // }


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Todo list</title>
</head>
<body>

    <div class="heading">
    
        <h3>New todo list :</h3>
    </div>


    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
        
        <?php
            if (isset($_POST['add']) && empty($task_in)) { ?>
                <p style="color:red;font-style: italic;"> please write something to add <p>
            
        <?php } ?>

        <input type="text" name="task" id="" class="task_inp">

        <button type="submit" name="add" class="task_btn">Add Task</button>

    </form>

    

<!-- making table to read the tasks -->


<table>

        <thead>

            <tr>

                <th>No.</th>
                <th>Task</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>
        </thead>

        <tbody>
        <?php 

            class UI extends Connection{
                
                public $user_prop;
                public $id;
                

                public function selectDB($user_param) {
                    $this->user_prop = $user_param;
            
                    //selection :
                    $dbSelect = $this->pdo->prepare("SELECT * FROM tasks WHERE user_id=:userid");
                    $dbSelect->bindParam(':userid', $this->user_prop , PDO::PARAM_STR);
                    $dbSelect->execute();

                    //deletion
                    if (isset($_GET['del_task'])) {
                        $this->id = $_GET['del_task'];

                        $dbDelete = $this->pdo->prepare("DELETE FROM tasks WHERE id=:id");
                        $dbDelete->bindParam(':id',$this->id,PDO::PARAM_INT);
                        $dbDelete->execute();
                        header("location: todo.php?user_id=$this->user_prop");
                    }
                   



                    $i=1;
                    while($row = $dbSelect->fetch(PDO::FETCH_ASSOC)) { ?>
            
                        <tr>

                            <td class="no"><?php echo $i; ?></td>

                            <td class="task"><?php echo $row['task']; ?></td>

                            <td class="delete"><a href="todo.php?user_id=<?php echo $this->user_prop;?>&del_task=<?php echo $row['id']; ?>">x</a></td>

                            <td style="text-align:center;"><a href="todo.update.php?user_id=<?php echo $this->user_prop;?>&up_task=<?php echo $row['id'];?>" style="text-decoration:none;color:white;background:blue;">^</a></td>

                        </tr>

                    <?php  $i++; }            // while loop ends here


                    
                      
                    
                    
                }
            }                  // class UI ends here
            
            
            $ui = new UI('mysql','todo');
            $ui->selectDB($user_in);
            
        ?>

            

        </tbody>
    </table>





</body>
</html>




