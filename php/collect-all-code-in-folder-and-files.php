<?php
function files($path)
{
    if (is_array($path)) {
        foreach ($path as $dir) {
            files($dir);
        }
    } else if (is_dir($path)) {
        $all = diffdoc($path, sdir($path));
        $dirs = $all["dirs"];
        $files = $all["files"];
        foreach ($dirs as $dir) {
            files($dir);
        }
    } else {
        $files = sdir($path);
    }
    if (isset($files)) {
        foreach ($files as $file) {
            if (!is_dir("$path/$file") && $file != "findfiles.php") {
                echo pfile($path, $file, [""]);
            } else if (is_dir("$path/$file") && !strfind($path, ".git")) {
                files("$path/$file");
            }
        }
    }
}
echo "<pre>";
files(".");
echo "</pre>";
?>