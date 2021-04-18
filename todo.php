<?php

   //connecting to database

  try{

   $db_name = "mysql:host=localhost;dbname=todo";
   $username ="root";
   $password ="test";


   $conn = new PDO($db_name, $username, $password);

    // echo "connected";


// //   starting query using prepare  

    

// insertion

    if ($_SERVER['REQUEST_METHOD'] == "POST"){

        $task = $_REQUEST['task'];
    }

    if (!empty($task)) {

        $insertQuery = "INSERT INTO tasks(task) VALUES(?)";
        $insrt = $conn->prepare($insertQuery);
        $insrt->execute([$task]);
    
    }


// selection - reading

    $selectQuery = "SELECT * FROM tasks";
    $slct = $conn->prepare($selectQuery);
    $slct->execute();

// deletion 

    if(isset($_GET['del_task'])){

        $id = $_GET['del_task'];

        $deleteQuery = "DELETE FROM tasks WHERE id=?";
        $dlt = $conn->prepare($deleteQuery);
        $dlt->execute([$id]);
        header('location: todo.php');
    }

  
    



   }catch(PDOException $e){

    echo "Error:".$e->getMessage();
   }


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
            if (isset($_POST['add']) && empty($task)) { ?>
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
            
            $i=1;
            while($row=$slct->fetch(PDO::FETCH_ASSOC)) { ?>

                    <tr>

                        <td class="no"><?php echo $i; ?></td>
                        <td class="task"><?php echo $row['task']; ?></td>
                        <td class="delete"><a href='todo.php?del_task=<?php echo $row['id']; ?>'>x</a></td>
                        <td style="text-align:center;"><a href='todo.update.php?up_task=<?php echo $row['id'];?>' style="text-decoration:none;color:white;background:blue;">^</a></td>
                    </tr>

                   
            
           
        <?php   $i++; } ?>

        </tbody>
    </table>


</body>
</html>


