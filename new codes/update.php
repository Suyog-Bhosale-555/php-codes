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
<form method="post">
    <input type="text" value="<?php echo $id?>" placeholder="ID" name="id">
    <br>
    <br>
    <input type="text" value="<?php echo $name?>" placeholder="NAME" name="name">
    <br>
    <br>
    <input type="text" value="<?php echo $age?>" placeholder="AGE" name="age">
    <br>
    <br>
    <input type="text" value="<?php echo $location?>" placeholder="LOCATION" name="location">
    <br>
    <br>
    <button value = "<?php echo $id?>" name="update">Update</button>
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