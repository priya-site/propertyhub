<?php

include "db.php";
session_start();
$broker_id = $_SESSION['user_id'];

// Ensure broker is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SESSION['role'] != 'broker') {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['user_name'];

/* ================= DASHBOARD STATS ================= */

/* New Leads */
$new_leads_query = mysqli_query($conn, "
SELECT COUNT(*) AS total 
FROM broker_leads 
WHERE broker_id='$broker_id' AND status='New'
");

$new_leads = mysqli_fetch_assoc($new_leads_query)['total'];

/* TOTAL ACTIVE LISTINGS */
$activeListingsQuery = $conn->prepare("
SELECT COUNT(*) as total 
FROM properties 
WHERE broker_id=? 
AND status='Active'
");
$activeListingsQuery->bind_param("i", $broker_id);
$activeListingsQuery->execute();
$activeListings = $activeListingsQuery->get_result()->fetch_assoc()['total'];


/* Closed Deals */
$closed_query = mysqli_query($conn, "
SELECT COUNT(*) AS total 
FROM broker_leads 
WHERE broker_id='$broker_id' AND status='Closed'
");

$closed_deals = mysqli_fetch_assoc($closed_query)['total'];

/* ================= LEADS CHART DATA ================= */

$newLead = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) AS total FROM broker_leads
WHERE broker_id='$broker_id' AND LOWER(status)='new'
"))['total'];

$contactedLead = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) AS total FROM broker_leads
WHERE broker_id='$broker_id' AND LOWER(status)='contacted'
"))['total'];

$closedLead = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) AS total FROM broker_leads
WHERE broker_id='$broker_id' AND LOWER(status)='closed'
"))['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broker Dashboard - PropertyHub</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: "#0A192F",
                        deepnavy: "#112240",
                        card: "#F3F4F6",
                        royal: "#6A0DAD",
                        lightroyal: "#8A2BE2",
                    }
                }
            }
        }
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gray-100 overflow-x-hidden">

    <?php include "broker-layout.php"; ?>

    <div class="flex">

        <!-- ================= MAIN CONTENT ================= -->
        <div class="flex-1 ml-0 md:ml-64 p-4 sm:p-6 md:p-10 max-w-full">

            <div class="max-w-7xl mx-auto">

                <h1 class="text-2xl md:text-3xl font-bold text-navy mb-6">
                    Welcome, <?php echo $username; ?> 👋
                </h1>

                <!-- STATS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <div class="bg-white p-6 rounded-xl shadow-md border border-lightroyal">
                        <h3 class="text-gray-500">New Leads</h3>
                        <p class="text-2xl font-bold text-royal mt-2"><?php echo $new_leads; ?></p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md border border-lightroyal">
                        <h3 class="text-gray-500">Active Listings</h3>
                        <p class="text-2xl font-bold text-royal mt-2"><?php echo $activeListings; ?></p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md border border-lightroyal">
                        <h3 class="text-gray-500">Closed Deals</h3>
                        <p class="text-2xl font-bold text-royal mt-2"><?php echo $closed_deals; ?></p>
                    </div>

                </div>

                <!-- CHART -->
                <div class="mt-10 bg-white p-6 rounded-xl shadow-md border border-lightroyal">

                    <h2 class="text-xl font-semibold mb-4 text-navy">
                        Leads Status
                    </h2>

                    <div class="h-64">
                        <canvas id="leadsChart"></canvas>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- ================= SCRIPTS ================= -->
    <script>

        // Chart.js
        const leadsCtx = document.getElementById('leadsChart').getContext('2d');
        const leadsChart = new Chart(leadsCtx, {
            type: 'pie',
            data: {
                labels: ['New', 'Contacted', 'Closed'],
                datasets: [{
                    data: [<?php echo $newLead; ?>, <?php echo $contactedLead; ?>, <?php echo $closedLead; ?>],
                    backgroundColor: ['#6A0DAD', '#8A2BE2', '#0A192F']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>

</body>

</html>