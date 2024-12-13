<form action="" method="post" >

<!-- <input type="text" placeholder="Enter ID" name="id">
<br/>
<br/> -->
<input type="text" placeholder="Enter name" name="name">
<br/>
<br/>
<input type="text" placeholder="Enter age" name="age">
<br/>
<br/>
<input type="text" placeholder="Enter location" name="location">
<br/>
<br/>
<button>INSERT</button>
</form>




<?php 
if(isset($_POST['name'])){

    // $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $location = $_POST['location'];

    include("./config.php");

    $query = $conn->prepare("
    INSERT INTO info (id,name,age,location)
    VALUES (null,'$name',$age,'$location')
    ");
    $result = $query->execute();
    if($result){
        echo "Data inserted";
    }else{
        echo "operaton failed";
    }

}




?>