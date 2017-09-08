<?php
include('config.php');

$qryObj = new mysqliQueryClass();
$query = $qryObj->getEmployeeName(1019);

if ($query) {
    print_r($query);
} else {
    echo 'An error occurred!';
}




/*==============================================


EXAMPLE
-------------

DEAR SEE THIS :- https://codepen.io/hanhpho/pen/pfHCh

-------------------------------------------------

Calculator Test

Description

The test is divided into two parts, one part HTML / JS and one part PHP. These parts will be referred to as frontend and backend from here on. 
You are allowed to search for resources online to help you complete the test, we don’t expect you to know everything by heart.
You may divide the file into several files if you feel that it is necessary.
The time limit is 60 minutes, so manage your time and don’t try to build overly advanced solutions. It’s better to complete the task.

To help you visualize how we see the end result being, please visit www.freedomfinance.se and look at the calculator there. The calculator should work exactly the same way, minus the styling.
Instructions, frontend

The sample code includes a fully functioning calculator, it calculates the monthly cost for a loan based on an average interest rate, loan amount and repayment time.
The loan amount and repayment time is provided by the end user through two input fields.
Your assignment is to replace these input fields with sliders, using jquery-ui.

The following points must be met for us to consider this assignment complete:
•	The amount input field must be replaced with a slider, and all of the following variables must be used by the slider; max_amount, min_amount, default_amount and step_amount.
When you drag the slider, the monthly cost should be calculated using the calculation implemented in the sample code.
•	The repayment years input field must be replaced with a slider, and all of the following variables must be used by the slider; max_repayment, min_repayment, default_repayment and step_repayment.
When you drag the slider, the monthly cost should be calculated using the calculation implemented in the sample code.
•	The sliders should not be draggable over the max_amount or max_repayment values. The same goes for min_amount and min_repayment.
•	The sliders should jump according to the step_amount and step_repayment variables. (interval/step)
•	The sliders should start with the value defined in default_amount and default_repayment.
We will also look at how you’ve solved it. Try to solve it in the best way possible while still managing your time. 
Instructions, backend

The sample code contains two functions used for fetching information from the database.
Your assignment is to wrap these functions in at least one class. There is also an error with the calculator_id input variable that needs to be fixed.

The following points must be met for us to consider this assignment complete:
•	The functions must be wrapped inside at least one class.
•	The issue with calculator_id must be fixed.
•	The script must accept calculator_id 1, 2 or no input at all. It should default to calculator_id 1.
Similar to the frontend assignment, we’ll also look at how you’ve solved it. Consider security issues, rewriting code and applying best practices wherever you see fit. But keep in mind that the time limit is 60 minutes.

*/



// they have code already done.need to replace with slider

<?php
error_reporting(0);

$iConnection = mysql_connect("localhost", "root", "");
$bSelectedDB = mysql_select_db("calculator", $iConnection);



/**
 * @return void
 */
function getAverageInterestRate() {
    $iSumInterest = 0;
    $iCountInterest = 0;

    $tSQL = "SELECT * FROM interest_rate";
    $iResult = mysql_query($tSQL);
    while ($aRow = mysql_fetch_assoc($iResult)) {
        $iSumInterest += $aRow['interest_rate'];
        $iCountInterest++;
    }

    return $iSumInterest / $iCountInterest;
}

/**
 * @return void
 */
function getSettings() {
    $tSQL = "SELECT * FROM setting";
    //if ($_REQUEST['calculator_id']) {
	if(isset($_REQUEST['calculator_id'])){
        $tSQL = $tSQL . " WHERE id = " . $_REQUEST['calculator_id'];
    }
    $iResult = mysql_query($tSQL);
    $aSetting = array();
    while ($aRow = mysql_fetch_assoc($iResult)) {
        $aSetting = $aRow;
        break;
    }
    return $aSetting;
}

$iInterestRate = getAverageInterestRate();
$aSetting = getSettings();
?>
<html>
<head>
    <title>Calculator</title>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
</head>
<body>
    <script>
        var max_amount = <?=$aSetting['max_amount']?>;
        var min_amount = <?=$aSetting['min_amount']?>;
        var default_amount = <?=$aSetting['default_amount']?>;
        var step_amount = <?=$aSetting['step_amount']?>;
        var interest = <?=$iInterestRate?>;

        var max_repayment = <?=$aSetting['max_repayment']?>;
        var min_repayment = <?=$aSetting['min_repayment']?>;
        var default_repayment = <?=$aSetting['default_repayment']?>;
        var step_repayment = <?=$aSetting['step_repayment']?>;

        $(document).ready(function() {
            $('#amount').change(function() {
                var months = $('#repayment').val() * 12;
                $('#monthly_cost').val(Math.round($(this).val() * (interest / 100) / 12 / (1 - Math.pow(1 + (interest / 100) / 12, (months * -1)))));
            });

            $('#repayment').change(function() {
                var months = $(this).val() * 12;
                $('#monthly_cost').val(Math.round($('#amount').val() * (interest / 100) / 12 / (1 - Math.pow(1 + (interest / 100) / 12, (months * -1)))));
            });

            $('#amount').trigger('change');
        });
    </script>

    <table>
        <tr>
            <th>Amount</th>
            <td><input type="text" id="amount" value="<?=$aSetting['default_amount']?>"/></td>
        </tr>
        <tr>
            <th>Repayment (years)</th>
            <td><input type="text" id="repayment" value="<?=$aSetting['default_repayment']?>" /></td>
        </tr>
        <tr>
            <th>Monthly cost</th>
            <td><input type="text" disabled="" id="monthly_cost" /></td>
        </tr>
    </table>
    <p>Interest rate <?=$iInterestRate?></p>
</body>









