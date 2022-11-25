<?php
function pfile($path, $file, $hide = array())
{
    if (array_search("name", $hide) === false) {
        $name = "<h3>$path/$file</h3>";
    } else {
        $name = null;
    }
    if (array_search("content", $hide) === false) {
        $content = "<pre>" . htmlspecialchars(file_get_contents($path . '/' . $file)) . "</pre>";
    } else {
        $content = null;
    }
    return  $name . $content;
}
?>