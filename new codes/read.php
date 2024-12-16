<?php
include("./config.php");
$getinfo = $conn->prepare("select * from info");
$getinfo->execute();
$infos = $getinfo->fetchAll();

echo "<table border='1'>";
echo "<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Age</th>
    <th>Location</th>
</tr>";

foreach($infos as $info){
    echo "<tr>
        <td>".$info['id']."</td>
        <td>".$info['name']."</td>
        <td>".$info['age']."</td>
        <td>".$info['location']."</td>
    </tr>";
}
echo "</table>";
?>