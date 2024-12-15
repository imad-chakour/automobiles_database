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

if (isset($_POST['Add'])) {
    if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
        $_SESSION['error'] = "All fields are required";
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "Mileage and year must be numeric";
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos (make, model, year, mileage) VALUES (:mk, :md, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':md' => $_POST['model'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage']
        ));
        $_SESSION['success'] = "Record added";
        header("Location: index.php");
        return;
    }
    // Redirect back to the form page if there are errors
    header("Location: add.php");
    return;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Chakour Imad's Automobile Tracker 10adf645</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
    <h1>Tracking Automobiles for <?= htmlentities($_SESSION['name']) ?></h1>
    <?php if (isset($_SESSION['error'])) : ?>
        <p style="color: red;"><?= htmlentities($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="post">
        <p>Make: <input type="text" name="make" size="60"/></p>
        <p>Model: <input type="text" name="model" size="60"/></p>
        <p>Year: <input type="text" name="year"/></p>
        <p>Mileage: <input type="text" name="mileage"/></p>
        <input type="submit" name="Add" value="Add">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</div>
</body>
</html>
