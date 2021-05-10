import css from '../css/style.css'
var $ = require('jquery');

/**
 * Form validation
 */
$('#expenseFileForm').on('submit', (event) => {
    if ($('#expensesUpload').val() != '') {
        event.target.submit();
    } else {
        alert ('Please, select an expense file for upload!');
        event.preventDefault();
    }
});