<?php
include("./config.php");
$getinfo = $conn->prepare("SELECT id,name FROM info");
$getinfo->execute();
$infos = $getinfo->fetchAll();

echo "<select>";
echo "<option>SELECT NAME</option>";
foreach($infos as $info){
   // echo "<option>".$info['id']."</option>";
    echo "<option value=".$info['id'].">".$info['name']."</option>";

}
echo "</select>";

?>