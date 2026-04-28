<?php
session_start();

if(isset($_POST['login'])){
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if($user === "admin" && $pass === "123"){
        $_SESSION['login'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Login gagal!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
</head>
<body>

<h2>Login Admin</h2>

<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
    Username: <input name="user" required><br><br>
    Password: <input type="password" name="pass" required><br><br>
    <button name="login">Login</button>
</form>

</body>
</html>