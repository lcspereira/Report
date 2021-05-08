<?php
require_once "../vendor/autoload.php";
use Classes\ExpenseTotalizer;
use Classes\InvalidFileException;
use Volnix\CSRF\CSRF;
session_start();

if (isset($_GET['export']) && ($_GET['export'] == 'yes')) {
    // Export expenses totals to CSV
    if (isset($_SESSION['totalizer'])) {
        ExpenseTotalizer::exportToCsv(unserialize($_SESSION['totalizer']));
    }
} else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
    <div class="default-sep">
    <?php
        if (isset($_POST['expenseSubmit']) && CSRF::validate($_POST)) {
            // Expenses file processing
            $totalizer = new ExpenseTotalizer();
            $destFilePath = '../uploads/' . time() . '.csv';
            try {
                move_uploaded_file ($_FILES['expensesUpload']['tmp_name'], $destFilePath);
                $totalizer->loadFromFile($destFilePath);
                $totalizer->totalize();
                echo ExpenseTotalizer::toHtml($totalizer);
                echo "Download this report as CSV - <a href='index.php?export=yes' target='_blank'>click here</a>";
                $_SESSION['totalizer'] = serialize($totalizer);
            } catch (InvalidFileException $ex) {
                echo "<script type='text/javascript'>alert('" . $ex->getMessage() . "');</script>";
            }
        }
    ?>
    </div>
    <div class="form-sep">
        <form action="index.php" method="post" enctype="multipart/form-data" name='expenseFileForm' id='expenseFileForm'>
            <input type="hidden" name="<?= CSRF::TOKEN_NAME ?>" value="<?= CSRF::getToken() ?>"/>
            <div class='default-sep'>
                Upload a new CSV file
            </div>

            <input type="file" name="expensesUpload" id="expensesUpload" class="default-sep" /><br />
            <input type="submit" value="Upload" name="expenseSubmit" id="expenseSubmit" class="default-sep"/>
        </form>
    </div>
    <script type="text/javascript" src="dist/bundle.js"></script>
</body>
</html>
<?php } ?>