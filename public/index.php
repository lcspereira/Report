<?php
require_once "../vendor/autoload.php";
use Classes\ExpenseTotalizer;
session_start();

if (isset($_GET['export']) && ($_GET['export'] == 'yes')) {
    if (isset($_SESSION['totalizer'])) {
        ExpenseTotalizer::exportToCsv(unserialize($_SESSION['totalizer']));
    }
} else {
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
    <?php
        if (isset($_POST['expenseSubmit'])) {
            $totalizer = new ExpenseTotalizer();
            $totalizer->loadFromFile($_FILES['expensesUpload']['tmp_name']);
            $totalizer->totalize();
            echo $totalizer->toHtml();
            echo "<br />Download this report as CSV - <a href='index.php?export=yes' target='_blank'>click here</a><br />";
            $_SESSION['totalizer'] = serialize($totalizer);
        }
    ?>
    <form action="index.php" method="post" enctype="multipart/form-data">
        Upload a new CSV file<br />
        <input type="file" name="expensesUpload" id="expensesUpload" /><br />
        <input type="submit" value="Upload" name="expenseSubmit" id="expenseSubmit" />
    </form>
</body>
</html>
<?php } ?>