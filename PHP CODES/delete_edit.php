<?php
       

include("./config.php");

$getinfo = $conn->prepare("SELECT * FROM info");
$getinfo->execute();
$infos = $getinfo->fetchAll();



echo "<table border='2'>";
foreach($infos as $info){
    echo "<tr>
        <td>".$info['id']."</td>
        <td>".$info['name']."</td>
        <td>".$info['age']."</td>
        <td>".$info['location']."</td>
        <td><form method='post'>
        <button name=delete value=".$info['id'].">Delete</button>
        <button name=update value=".$info['id']."><a href = 'update.php?id=".$info['id']."' style='color: black; text-decoration: none;'>Update</a></button>
        </form>
        </td>
        
    </tr>";
}
echo "</table>";

if(isset($_POST['delete'])){
    echo $id = $_POST['delete'];
    $getinfo = $conn->prepare("DELETE FROM info WHERE id='$id'");
    
    if($getinfo->execute()){
        echo " th record deleted";

    }else{
        echo "record not deleted";
    }

}

?>