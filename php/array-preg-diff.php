<?php
function array_preg_diff($a, $p)
{
    foreach ($a as $i => $v)
        if (preg_match($p, $v))
            unset($a[$i]);
    return $a;
}
?>
