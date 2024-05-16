// app/helpers.php
<?php

if (!function_exists('calculateEMI')) {
    function calculateEMI($loanAmount, $interestRate, $loanDuration) {
        // Convert annual interest rate to monthly rate
        $monthlyInterestRate = ($interestRate / 12) / 100;

        // Calculate EMI using the formula
        $emi = $loanAmount * $monthlyInterestRate * pow((1 + $monthlyInterestRate), $loanDuration) / (pow((1 + $monthlyInterestRate), $loanDuration) - 1);

        return round($emi, 2); // Round off EMI to 2 decimal places
    }
}
