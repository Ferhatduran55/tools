<?php
function diagonalDifference($arr) {
    $m1 = 0; $m2 = 0;
    $n = count($arr);
    for ($i = 0; $i < $n; $i++)
    {
        $m1 += $arr[$i][$i];
        $m2 += $arr[$i][$n-$i-1];
    }
    
    return abs($m1 - $m2);
}
?>