<?php
function strfind($str, $find)
{
    if (stripos(strtolower($str), $find) !== false) {
        return true;
    } else {
        return false;
    }
}
?>
