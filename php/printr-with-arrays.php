<?php
function prt(...$data)
{
    for ($i = 0; $i < count($data); $i++) {
        echo '<pre>';
        print_r($data[$i]);
        echo '</pre>';
    }
}
?>