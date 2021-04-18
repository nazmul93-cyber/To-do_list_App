<?php

   //connecting to database

  try{

   $db_name = "mysql:host=localhost;dbname=todo";
   $username ="root";
   $password ="test";


   $conn = new PDO($db_name, $username, $password);

    // echo "connected";


// update 

    if (isset($_GET['up_task']) && isset($_POST['update'])) {

        $id = $_GET['up_task'];
        $up_task = $_POST['task'];

        $updateQuery = "UPDATE tasks SET task=? WHERE id=?";
        $updt = $conn->prepare($updateQuery);
        $updt->execute([$up_task,$id]);
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


