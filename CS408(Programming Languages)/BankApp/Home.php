<html>
<head>
<title>Bank PHP Demo - Home</title>
<link rel="stylesheet" type="text/css" href="Stylesheet.css">
</head>
<center>

<body>

<div class="Login">
<b>Login Information</b><p>
<form action="<?php
echo htmlspecialchars($_SERVER["PHP_SELF"]);
?>" method="post">
Username: <input type="text" name="username"> 
Password: <input type="password" name="password">
<input type="submit" name="Login" value="Login"> <input type="submit" value="Create Account"></form>
</div>
<br>

<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['Login'])) {
        $username = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);
        if (file_exists($username)) {
            $file = fopen($username, "r+");
            if (trim(fgets($file)) == $password) {
                fclose($file);
                $_SESSION['username'] = $username;
                header("Location: Panel.php");
            } else
                echo "<b><font color=\"red\">INVALID USERNAME OR PASSWORD.</font></b>";
        } else if ($username != "" or $password != "")
            echo "<b><font color=\"red\">INVALID USERNAME OR PASSWORD.</font></b>";
    } else
        header('Location: NewAccount.php');
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

</body>
</center>
</html>