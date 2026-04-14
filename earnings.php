<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

if($_SESSION['role'] != 'owner'){
    header("Location: login.html");
    exit();
}

$username = $_SESSION['user_name'];

include "db.php";
include "functions.php";

$owner_id = $_SESSION['user_id'];

/* TOTAL EARNINGS */
$total_sql = "SELECT SUM(amount) AS total FROM earnings 
              WHERE owner_id=? AND status='completed'";

$stmt = $conn->prepare($total_sql);
$stmt->bind_param("i",$owner_id);
$stmt->execute();
$total_result = $stmt->get_result();
$total = $total_result->fetch_assoc()['total'] ?? 0;

/* THIS MONTH */
$month_sql = "SELECT SUM(amount) AS month_total FROM earnings
              WHERE owner_id=? 
              AND status='completed'
              AND MONTH(created_at)=MONTH(CURRENT_DATE())
              AND YEAR(created_at)=YEAR(CURRENT_DATE())";

$stmt = $conn->prepare($month_sql);
$stmt->bind_param("i",$owner_id);
$stmt->execute();
$month_result = $stmt->get_result();
$month = $month_result->fetch_assoc()['month_total'] ?? 0;

/* COMPLETED DEALS */
$deal_sql = "SELECT COUNT(*) AS deals FROM earnings
             WHERE owner_id=? AND status='completed'";

$stmt = $conn->prepare($deal_sql);
$stmt->bind_param("i",$owner_id);
$stmt->execute();
$deal_result = $stmt->get_result();
$deals = $deal_result->fetch_assoc()['deals'];

/* RECENT TRANSACTIONS */
$transaction_sql = "SELECT * FROM earnings 
                    WHERE owner_id=? AND status='completed'
                    ORDER BY created_at DESC 
                    LIMIT 5";

$stmt = $conn->prepare($transaction_sql);
$stmt->bind_param("i",$owner_id);
$stmt->execute();
$transactions = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Earnings - PropertyHub</title>

<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>

<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        navy: "#0A192F",
        deepnavy: "#112240",
        royal: "#6A0DAD",
        lightroyal: "#8A2BE2",
        card: "#F3F4F6"
      }
    }
  }
}
</script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gray-100 overflow-x-hidden">

<!-- ✅ OWNER COMMON LAYOUT -->
<?php include "owner-layout.php"; ?>

<div class="flex">

<!-- ================= MAIN CONTENT ================= -->
<div class="flex-1 w-full md:ml-64 p-4 sm:p-6 md:p-10">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-navy">
            Earnings Overview
        </h1>
        <p class="text-gray-500 mt-2 text-sm sm:text-base">
            Track your property income and performance.
        </p>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-xl shadow-md border border-lightroyal">
            <h3 class="text-gray-500 text-sm sm:text-base">Total Earnings</h3>
            <p class="text-2xl font-bold text-green-600 mt-2">
                ₹ <?php echo formatPrice($total); ?>
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border border-lightroyal">
            <h3 class="text-gray-500 text-sm sm:text-base">This Month</h3>
            <p class="text-2xl font-bold text-royal mt-2">
               ₹ <?php echo formatPrice($month); ?>
            </p>
        </div>


    </div>

    <!-- TRANSACTIONS -->
    <div class="mt-10 bg-white p-4 sm:p-6 rounded-xl shadow-md border border-lightroyal">

        <h2 class="text-lg sm:text-xl font-semibold mb-4 text-navy">
            Recent Transactions
        </h2>

        <div class="space-y-4">

            <?php while($t = $transactions->fetch_assoc()) { ?>

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 p-4 bg-gray-50 rounded-lg">

                <div class="w-full sm:w-auto">
                    <p class="font-semibold text-sm sm:text-base truncate">
                        <?php echo $t['property_name']; ?>
                    </p>
                    <p class="text-xs sm:text-sm text-gray-500">
                        <?php echo ucfirst($t['status']); ?>
                    </p>
                </div>

                <span class="font-bold text-sm sm:text-base 
                <?php echo $t['status']=='completed' ? 'text-green-600':'text-yellow-500'; ?>">
                ₹ <?php echo formatPrice($t['amount']); ?>
                </span>

            </div>

            <?php } ?>

        </div>

    </div>

</div>

</div>

</body>
</html>