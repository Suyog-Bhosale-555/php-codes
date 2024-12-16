<form action="" method="post">
    <input type="text" name="search" placeholder="Enter name to search">
    <button>Search</button>
</form>

<?php
    include('./config.php');

    if(isset($_POST['search'])){

        $name = $_POST['search'];

        $searchinfo = $conn->prepare("SELECT * FROM info WHERE name like '%$name%'");
        $searchinfo->execute();
        $result = $searchinfo->fetchAll();

        echo "<table border='1'>";
        echo "<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Location</th>
        </tr>";
        
        foreach($result as $info){
            echo "<tr>
                <td>".$info['id']."</td>
                <td>".$info['name']."</td>
                <td>".$info['age']."</td>
                <td>".$info['location']."</td>
            </tr>";
        }
        echo "</table>";
        
    }

  

?>