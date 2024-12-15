<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

if (isset($_POST['save'])) {
    if (isset($_POST['autos_id']) && isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {
        $stmt = $pdo->prepare('UPDATE autos SET make = :mk, model = :md, year = :yr, mileage = :mi WHERE autos_id = :id');
        $stmt->execute(array(
            ':id' => $_POST['autos_id'],
            ':mk' => $_POST['make'],
            ':md' => $_POST['model'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage']
        ));
        $_SESSION['success'] = "Record edited";
        header("Location: index.php");
        return;
    }
}

if (!isset($_GET['autos_id']) || !is_numeric($_GET['autos_id'])) {
    $_SESSION['error'] = "Invalid request";
    header("Location: index.php");
    return;
}

$stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :id");
$stmt->execute(array(':id' => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row === false) {
    $_SESSION['error'] = "Record not found";
    header("Location: index.php");
    return;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Automobile</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
    <div class="container">
        <h1>Editing Automobile</h1>
        <form method="post">
            <p>Make: <input type="text" name="make" value="<?= htmlentities($row['make']) ?>" size="60"></p>
            <p>Model: <input type="text" name="model" value="<?= htmlentities($row['model']) ?>" size="60"></p>
            <p>Year: <input type="text" name="year" value="<?= htmlentities($row['year']) ?>"></p>
            <p>Mileage: <input type="text" name="mileage" value="<?= htmlentities($row['mileage']) ?>"></p>
            <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
            <input type="submit" name="save" value="Save">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </div>
</body>
</html>
