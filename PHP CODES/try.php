<!--------------------INSERT RECORD----------------------- -->
<body style="background-color: #c3c3c3;">

<form action="" method="post" style="background-color: #f4f4f4; padding: 20px; border-radius: 8px; max-width: 300px; margin: auto;" >

<!-- <input type="text" placeholder="Enter ID" name="id">
<br/>
<br/> -->
<input type="text" placeholder="Enter name" name="name" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
<br/>
<br/>
<input type="text" placeholder="Enter age" name="age" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
<br/>
<br/>
<input type="text" placeholder="Enter location" name="location" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
<br/>
<br/>
<button style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">INSERT</button>
</form>

</body>


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




<!-------------------DELETE RECORD----------------------------- -->
<?php
       

include("./config.php");

$getinfo = $conn->prepare("SELECT * FROM info");
$getinfo->execute();
$infos = $getinfo->fetchAll();



echo "<table border='2' style='width:100%; border-collapse: collapse; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 25px; overflow: hidden;'>";
echo "<tr style='background-color: #22201f; color: white;'>
    <th style='padding: 12px; text-align: left; border-bottom: 1px solid #ddd;'>ID</th>
    <th style='padding: 12px; text-align: left; border-bottom: 1px solid #ddd;'>Name</th>
    <th style='padding: 12px; text-align: left; border-bottom: 1px solid #ddd;'>Age</th>
    <th style='padding: 12px; text-align: left; border-bottom: 1px solid #ddd;'>Location</th>
    <th style='padding: 12px; text-align: center; border-bottom: 1px solid #ddd;'>Delete/Update</th>
</tr>";
foreach($infos as $info){
    echo "<tr style='background-color: #6a6a6a; color: white;'>
        <td style='padding: 8px; border-bottom: 1px solid #ddd;'>".$info['id']."</td>
        <td style='padding: 8px; border-bottom: 1px solid #ddd;'>".$info['name']."</td>
        <td style='padding: 8px; border-bottom: 1px solid #ddd;'>".$info['age']."</td>
        <td style='padding: 8px; border-bottom: 1px solid #ddd;'>".$info['location']."</td>
        <td style='padding: 8px; text-align: center;'>
            <form method='post' style='display: inline;'>
            <button name='delete' value='".$info['id']."' style='width: 45%; padding: 10px; background-color: #433d3c; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 5px;'>Delete</button>
            </form>
            <form method='post' style='display: inline;'>
            <button name='update' value='".$info['id']."' style='width: 45%; padding: 10px; background-color: #433d3c; color: white; border: none; border-radius: 4px; cursor: pointer;'><a href = 'try.php?id=".$info['id']."' style='color: white; text-decoration: none;'>Update</a></button>
            </form>
        </td>
    </tr>";
}
echo "</table>";

if(isset($_POST['delete'])){
    $id = $_POST['delete'];
    $getinfo = $conn->prepare("DELETE FROM info WHERE id='$id'");
    
    if($getinfo->execute()){
        echo "record deleted";

    }else{
        echo "record not deleted";
    }

}

?>


<!--------------------UPDATE RECORD------------------------- -->

<?php
 include ("./config.php");

 if(isset($_GET['id'])){
    $id = $_GET['id'];
    $getinfo = $conn->prepare("SELECT * FROM info WHERE id='$id'");
    $getinfo->execute();
    $record = $getinfo->fetchAll();

    $id = $record[0]['id'];
    $name = $record[0]['name'];
    $age = $record[0]['age'];
    $location = $record[0]['location'];

 }
?>
<form method="post" style="background-color: #f4f4f4; padding: 20px; border-radius: 8px; max-width: 300px; margin: auto;">
    <input type="text" value="<?php echo $id?>" placeholder="ID" name="id" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
    <br>
    <br>
    <input type="text" value="<?php echo $name?>" placeholder="NAME" name="name" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
    <br>
    <br>
    <input type="text" value="<?php echo $age?>" placeholder="AGE" name="age" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
    <br>
    <br>
    <input type="text" value="<?php echo $location?>" placeholder="LOCATION" name="location" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
    <br>
    <br>
    <button value = "<?php echo $id?>" name="update" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Update</button>
</form>

<?php
if (isset($_POST['update'])){
   $id = $_POST['update'];
   $name = $_POST['name'];
   $age = $_POST['age'];
   $location = $_POST['location'];


   $location = $_POST['location'];
   $updateinfo = $conn->prepare
   ("UPDATE info 
   SET 
   id='$id',
   name='$name',
   age='$age',
   location='$location' 
   WHERE id='$id'");

    if($updateinfo->execute()){
        echo "record Updated";
    }else{
        echo "Update failed";
    }
}
?>