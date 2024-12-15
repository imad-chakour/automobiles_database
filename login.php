<?php
session_start();

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Replace this with your hashed password

if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

if (isset($_POST['email']) && isset($_POST['pass'])) {
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION['error'] = "Both email and password are required";
        header("Location: login.php");
        return;
    } else {
        $check = hash('md5', $salt . $_POST['pass']);
        if ($check == $stored_hash) {
            $_SESSION['name'] = $_POST['email'];
            header("Location: index.php");
            return;
        } else {
            $_SESSION['error'] = "Invalid password";
            header("Location: login.php");
            return;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Chakour Imad's Login Page - 10adf645</title>
</head>
<body>
<div class="container">
    <h1>Please Log In</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST">
        <label for="email">User Name</label>
        <input type="text" name="email" id="email">
        <br>
        <label for="pass">Password</label>
        <input type="password" name="pass" id="pass">
        <br>
        <input type="submit" value="Log In">
        <a href="logout.php">Cancel</a>
    </form>

    <p>
        For a password hint, view source and find a password hint
        in the HTML comments.
        <!-- Hint: The password is 'php' (all lower case) followed by 123. -->
    </p>
</div>
</body>
</html>
