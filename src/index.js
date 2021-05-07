import css from '../css/style.css'
var $ = require('jquery');

const validateFileForm = (form) => {
    if (document.querySelector('#expensesUpload').value != '') {
        form.submit();
    } else {
        alert('Please, select a file for upload.');
    }
}

$('#expenseFileForm').on('submit', (event) => {
    if ($('#expensesUpload').val() != '') {
        event.target.submit();
    } else {
        alert ('Please, select an expenses file for upload!');
        event.preventDefault();
    }
});