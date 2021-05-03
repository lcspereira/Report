<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
  "http://www.w3.org/TR/html4/loose.dtd">
<?php
require_once "../vendor/autoload.php";
use Classes\ExpenseTotalizer;
use Volnix\CSRF\CSRF;
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
        if (isset($_POST['expenseSubmit']) && CSRF::validate($_POST)) {
            $totalizer = new ExpenseTotalizer();
            $destFilePath = '../uploads/' . time() . '.csv';
            copy ($_FILES['expensesUpload']['tmp_name'], $destFilePath);
            $totalizer->loadFromFile($destFilePath);
            $totalizer->totalize();
            echo $totalizer->toHtml();
            echo "<br />Download this report as CSV - <a href='index.php?export=yes' target='_blank'>click here</a><br />";
            $_SESSION['totalizer'] = serialize($totalizer);
        }
    ?>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="<?= CSRF::TOKEN_NAME ?>" value="<?= CSRF::getToken() ?>"/>
        Upload a new CSV file<br />
        <input type="file" name="expensesUpload" id="expensesUpload" /><br />
        <input type="submit" value="Upload" name="expenseSubmit" id="expenseSubmit" />
    </form>
</body>
</html>
<?php } ?>