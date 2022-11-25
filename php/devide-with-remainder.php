<?php
function divide_with_remainder($dividend, $divisor)
{
    $quotient = (int)($dividend / $divisor);
    $remainder = $dividend % $divisor;
    return array($quotient, $remainder);
}
?>