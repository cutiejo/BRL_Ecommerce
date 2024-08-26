<?php include("./connections.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <!-- ======= Styles ====== -->
        <link rel="stylesheet" href="../Admin/assets/css/style.css">
        <link rel="stylesheet" href="../Admin/assets/imgs">
    </head>


<body>
    <?php include("./Admin/dashboard.php"); ?>
    <?php include("./Admin/product.php"); ?>
    <?php include("./Admin/purchase.php"); ?>
    <?php include("./Admin/reports.php"); ?>
    <?php include("./Admin/user.php"); ?>
    <?php include("./Admin/settings.php"); ?>
    <?php include("./Admin/logout.php"); ?>

    <script src="../Admin/assets/js/main.js"></script>
    <!-- ... (other scripts) ... -->
</body>

</html>
