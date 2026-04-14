<?php
session_start();

$target = isset($_GET['role']) ? $_GET['role'] : '';

/* NOT LOGGED IN */
if(!isset($_SESSION['user_id'])){
    header("Location: signup.html");
    exit();
}

$current_role = $_SESSION['role'];

/* MATCHING ROLE → REDIRECT */

if($target == "buyer" && $current_role == "user"){
    header("Location: user-dashboard.php");
    exit();
}

if($target == "seller" && $current_role == "owner"){
    header("Location: owner-dashboard.php");
    exit();
}

if($target == "broker" && $current_role == "broker"){
    header("Location: broker-dashboard.php");
    exit();
}

/* ❌ ROLE MISMATCH → SHOW SWEET ALERT */
?>

<!DOCTYPE html>
<html>
<head>
<title>Access Restricted</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<script>

let message = "";

<?php
if($current_role == "user"){
    echo "message = 'You are logged in as USER. To access Seller or Broker features, please sign up as Owner or Broker.';";
}

if($current_role == "owner"){
    echo "message = 'You are logged in as OWNER. To access Buyer or Broker features, please use the correct account.';";
}

if($current_role == "broker"){
    echo "message = 'You are logged in as BROKER. To access Buyer or Seller features, please use the correct account.';";
}
?>

Swal.fire({
    icon: 'error',
    title: 'Access Denied 🚫',
    text: message,
    confirmButtonColor: '#6A0DAD'
}).then(() => {
    window.location.href = "index.php";
});

</script>

</body>
</html>