<?php
function diffdoc($path, $data)
{
    $output = array(
        "dirs" => array(),
        "files" => array(),
    );
    foreach ($data as $doc) {
        if (is_dir($doc)) {
            array_push($output["dirs"], "$path/$doc");
        } else {
            array_push($output["files"], "$doc");
        }
    }
    return $output;
}
?>
