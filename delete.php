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

if (isset($_POST['delete']) && isset($_POST['autos_id'])) {
    $stmt = $pdo->prepare('DELETE FROM autos WHERE autos_id = :id');
    $stmt->execute(array(':id' => $_POST['autos_id']));
    $_SESSION['success'] = "Record deleted";
    header("Location: index.php");
    return;
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
    <title>Delete Automobile</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
    <div class="container">
        <p>Confirm: Deleting <?= htmlentities($row['make']) ?></p>
        <form method="post">
            <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
            <input type="submit" name="delete" value="Delete">
            <a href="index.php">Cancel</a><br/>
        </form>
    </div>
</body>
</html>
