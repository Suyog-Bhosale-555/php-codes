<?php
include("./config.php");
// <!--------------------INSERT RECORD------------------------->
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD Application</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="forms-container">
        <!-- INSERT FORM -->
        <form action="" method="post" class="insert-form">
            <input type="text" placeholder="Enter name" name="name" required>
            <input type="number" placeholder="Enter age" name="age" required>
            <input type="text" placeholder="Enter location" name="location" required>
            <button type="submit">INSERT</button>
        </form>

        <!-- UPDATE FORM -->
        <?php
        include("./config.php");
        
        // Check if an update is being prepared
        $update_id = '';
        $update_name = '';
        $update_age = '';
        $update_location = '';

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $getinfo = $conn->prepare("SELECT * FROM info WHERE id=:id");
            $getinfo->execute([':id' => $id]);
            $record = $getinfo->fetch(PDO::FETCH_ASSOC);

            if($record){
                $update_id = $record['id'];
                $update_name = $record['name'];
                $update_age = $record['age'];
                $update_location = $record['location'];
            }
        }
        ?>
        <form method="post" class="update-record-form">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($update_id); ?>">
            <input type="text" value="<?php echo htmlspecialchars($update_name); ?>" placeholder="NAME" name="name" required>
            <input type="number" value="<?php echo htmlspecialchars($update_age); ?>" placeholder="AGE" name="age" required>
            <input type="text" value="<?php echo htmlspecialchars($update_location); ?>" placeholder="LOCATION" name="location" required>
            <button name="update" <?php echo $update_id ? '' : 'disabled'; ?>>
                <?php echo $update_id ? 'UPDATE' : 'SELECT RECORD TO UPDATE'; ?>
            </button>
        </form>

        <!-- IMPROVED SEARCH FORM -->
        <form action="" method="post" class="update-record-form">
            <input type="text" name="search" placeholder="Search by Name, Age, or Location">
            <button type="submit">Search</button>
        </form>

    </div>

    <?php
    // INSERT RECORD LOGIC
    if(isset($_POST['name']) && !isset($_POST['update'])){
        $name = $_POST['name'];
        $age = $_POST['age'];
        $location = $_POST['location'];

        $query = $conn->prepare("INSERT INTO info (name, age, location) VALUES (:name, :age, :location)");
        $result = $query->execute([
            ':name' => $name,
            ':age' => $age,
            ':location' => $location
        ]);

        if($result){
            echo "<div class='message success'><script>alert ('Data inserted successfully')</script></div>";
            header("Refresh:0");
        } else {
            echo "<div class='message error'><script>alert ('Operation Failed')</script></div>";
        }
    }

    // UPDATE RECORD LOGIC
    if(isset($_POST['update']) && isset($_POST['id'])){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $location = $_POST['location'];

        $updateinfo = $conn->prepare(
            "UPDATE info SET name=:name, age=:age, location=:location WHERE id=:id"
        );

        $result = $updateinfo->execute([
            ':name' => $name,
            ':age' => $age,
            ':location' => $location,
            ':id' => $id
        ]);

        if($result){
            echo "<div class='message success'><script>alert ('Data Updated successfully')</script></div>";
            header("Refresh:0");
        } else {
            echo "<div class='message error'><script>alert ('Update Failed')</script></div>";
        }
    }

    // IMPROVED SEARCH AND DISPLAY LOGIC
    include("./config.php");
    
    // Determine which records to fetch
    if(isset($_POST['search'])){
        // Sanitize search input
        $search = $_POST['search'];
        
        // Prepare search query with flexible matching
        $searchinfo = $conn->prepare("SELECT * FROM info WHERE 
            name LIKE :search OR 
            location LIKE :search OR 
            age LIKE :search");
        $searchinfo->execute([':search' => "%$search%"]);
        $infos = $searchinfo->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // If no search, fetch all records
        $getinfo = $conn->prepare("SELECT * FROM info");
        $getinfo->execute();
        $infos = $getinfo->fetchAll(PDO::FETCH_ASSOC);
    }

    // Display records in a single table
    echo "<table>";
    echo "<tr>
        <th>ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>Location</th>
        <th>Delete/Update</th>
    </tr>";
    
    // Check if any records exist
    if(count($infos) > 0){
        foreach($infos as $info){
            echo "<tr>
                <td>".$info['id']."</td>
                <td>".$info['name']."</td>
                <td>".$info['age']."</td>
                <td>".$info['location']."</td>
                <td class='action-buttons'>
                    <form method='post' class='delete-form'>
                        <button name='delete' value='".$info['id']."'>Delete</button>
                    </form>
                    <form method='get' class='update-form'>
                        <button formaction='new2.php' name='id' value='".$info['id']."'>Update</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        // Display message if no records found
        echo "<tr><td colspan='5'>No records found.</td></tr>";
    }
    echo "</table>";

    // DELETE RECORD LOGIC
    if(isset($_POST['delete'])){
        $id = $_POST['delete'];
        $deleteinfo = $conn->prepare("DELETE FROM info WHERE id=:id");
        
        if($deleteinfo->execute([':id' => $id])){
            header("Refresh:0");
            echo "<div class='message success'><script>alert ('Record Deleted Successfully')</script></div>";
            
        } else {
            echo "<div class='message error'><script>alert ('Record Not Deleted')</script></div>";
        }
    }
    ?>
</body>
</html>