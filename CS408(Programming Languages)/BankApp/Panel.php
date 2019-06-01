<html>
<head>
<title>Bank PHP Demo - Panel</title>
<link rel="stylesheet" type="text/css" href="Stylesheet.css">
</head>
<center>
<body>

<div class="Panel1">
<b>User Info</b><p>
<?php
session_start();

if (file_exists($_SESSION['username'])) {
    $file                = fopen($_SESSION['username'], "r+");
    $GLOBALS['username'] = $_SESSION['username'];
    $GLOBALS['password'] = trim(fgets($file));
    $GLOBALS['name']     = trim(fgets($file));
    $GLOBALS['type']     = trim(fgets($file));
    $GLOBALS['balance']  = trim(fgets($file));
    $GLOBALS['history']  = array();
    while (!feof($file))
        array_push($GLOBALS['history'], fgets($file));
    settype($GLOBALS['balance'], "double");
    echo "<b>Name:</b> " . $name . "<br>";
    echo "<b>Account Type:</b> " . $type . "<br>";
    echo "<b>Balance:</b> $" . sprintf("%01.2f", $GLOBALS['balance']);
    fclose($file);
} else {
    header('Location: Home.php');
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['Logout'])) {
        unset($_SESSION['username']);
        header('Location: Home.php');
    } else if (isset($_POST['DeleteAccount'])) {
        unlink($_SESSION['username']);
        unset($_SESSION['username']);
        header('Location: Home.php');
    }
}
?>
<form action="<?php
echo htmlspecialchars($_SERVER["PHP_SELF"]);
?>" method="post">
<input type="submit" value="Logout" name="Logout"> <input type="submit" value="Delete Account" name="DeleteAccount"></form>
</div>
<br>

<div class="Panel2">
<b>Modify Account</b><p>

<form action="<?php
echo htmlspecialchars($_SERVER["PHP_SELF"]);
?>" method="post">
Amount<br><input type="number" type="number" step="0.01" name="depositamount" size="33" maxlength="10"> <input type="submit" value="Deposit" name="Deposit"><p>
Amount<br><input type="number" type="number" step="0.01" name="withdrawamount" size="33" maxlength="10">  <input type="submit" value="Withdraw" name="Withdraw"><p>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['Deposit'])) {
        if ($_POST['depositamount'] < 0.01)
            echo "<b><font color=\"maroon\"><center>INVALID DEPOSIT AMOUNT.</font></b></center>";
        else {
            $GLOBALS['balance'] += $_POST['depositamount'];
            array_push($GLOBALS['history'], "Deposited $" . sprintf("%01.2f", $_POST['depositamount']));
            save();
            header('Location: Panel.php');
        }
    } else if (isset($_POST['Withdraw'])) {
        if ($_POST['withdrawamount'] < 0.01)
            echo "<b><font color=\"maroon\"><center>INVALID WITHDRAW AMOUNT.</font></b></center>";
        else if ($_POST['withdrawamount'] > $GLOBALS['balance'])
            echo "<b><font color=\"maroon\"><center>INSUFFICIENT FUNDS.</font></b></center>";
        else if ($GLOBALS['type'] == "Gold" and $_POST['withdrawamount'] > 20000 or $GLOBALS['type'] == "Platinum" and $_POST['withdrawamount'] > 50000)
            echo "<b><font color=\"maroon\"><center>CANNOT WITHDRAW ABOVE ACCOUNT LIMIT.</font></b></center>";
        else {
            $GLOBALS['balance'] -= $_POST['withdrawamount'];
            array_push($GLOBALS['history'], "Withdrew $" . sprintf("%01.2f", $_POST['withdrawamount']));
            save();
            header('Location: Panel.php');
        }
    }
}

function save()
{
    unlink($GLOBALS['username']);
    $file = fopen($GLOBALS['username'], "x+");
    fwrite($file, $GLOBALS['password'] . "\n" . $GLOBALS['name'] . "\n" . $GLOBALS['type'] . "\n" . $GLOBALS['balance'] . "\n");
    for ($i = 0; $i < count($GLOBALS['history']); $i++) {
        fwrite($file, trim($GLOBALS['history'][$i]));
        if ($i !== count($GLOBALS['history']) - 1)
            fwrite($file, "\n");
    }
    fclose($file);
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
</form>
</div>
<br>

<div class="Panel3">
<b>Account History</b><p>
<?php
for ($i = 0; $i < count($GLOBALS['history']); $i++) {
    echo "$i) " . $GLOBALS['history'][$i] . "<br>";
}
?>
</div>

</body>
</center>
</html>