<?php
require_once "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Imad Chakour - Autos Database - 10adf645</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container1">
    <h1>Welcome to the Automobiles Database</h1>
    <p>
        <a href="login.php">Please log in</a>
    </p>
    <p>
        Attempt to go to 
        <a href="add.php">add.php</a> without logging in - it should fail with an error message.
    </p>
    <!-- Message for credentials -->
    <p style="color: blue;">
        Note: You can use any email, but the password should be <strong>php123</strong>.
    </p>
</div>

<?php if (isset($_SESSION['name'])) : ?>
    <div class="container">
        <?php
        if (isset($_SESSION['success'])) {
            echo '<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n";
            unset($_SESSION['success']);
        }

        $stmt = $pdo->query("SELECT autos_id, make, year, mileage, model FROM autos");
        
        // Check if there are any rows
        if ($stmt->rowCount() > 0) {
            // Start the table and define the table header
            echo "<table border='1'>\n";
            echo "<thead><tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr></thead>\n";

            // Fetch and display data from the database
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlentities($row['make']) . "</td>";
                echo "<td>" . htmlentities($row['model']) . "</td>";
                echo "<td>" . htmlentities($row['year']) . "</td>";
                echo "<td>" . htmlentities($row['mileage']) . "</td>";
                echo "<td>";
                echo '<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ';
                echo '<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>';
                echo "</td>";
                echo "</tr>";
            }
            // Close the table
            echo "</table>\n";
        } else {
            // If no rows found, display a message
            echo "<p>No rows found</p>";
        }
        ?>
        <a href="add.php">Add New Entry</a><br/><br/>
        <a href="logout.php">Logout</a><br/>
    </div>
<?php endif; ?>
</body>
</html>
