<?php
function addQuotesToArrayItems(array $array, $sign = "'", $between = ' ,')
{
    return $sign . implode($sign . $between . $sign, $array) . $sign;
}
?>