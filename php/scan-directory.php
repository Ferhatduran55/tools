<?php
function sdir($path)
{
    if (is_dir($path)) {
        return array_diff(scandir($path), array('.', '..'));
    }
}
?>