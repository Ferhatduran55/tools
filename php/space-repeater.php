<?php
function Space($number)
{
    if ($number > 0) {
        return str_repeat('&nbsp;', $number);
    }
}
?>
