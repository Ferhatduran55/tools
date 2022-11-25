<?php
function arrayDiff($A, $B)
{
    $intersect = array_intersect($A, $B);
    return array_merge(array_diff($A, $intersect), array_diff($B, $intersect));
}
?>
