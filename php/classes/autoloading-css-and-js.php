<?php
class FileManagement
{
    static $dir = "Assets/";
    static $assets = array("Assets" => array("css" => array(), "js" => array()));
    public static function DetectAssets()
    {
        foreach (scandir(self::$dir . self::$assets[0]) as $folder) {
            if ($folder != "." && $folder != "..") {
                foreach (scandir(self::$dir . self::$assets[0] . $folder) as $file) {
                    if ($file != "." && $file != "..") {
                        switch ($folder) {
                            case "css":
                                array_push(self::$assets["Assets"]["css"], $file);
                                break;
                            case "js":
                                array_push(self::$assets["Assets"]["js"], $file);
                                break;
                        }
                    }
                }
            }
        }
    }
    public static function GetAssets($arg)
    {
        if (isset($arg)) {
            switch ($arg) {
                case "css":
                    foreach (self::$assets["Assets"]["css"] as $file) {
                        $asset = self::$dir . "css/" . $file;
                        echo '<link rel="stylesheet" href="' . $asset . '"/>';
                    }
                    break;
                case "js":
                    foreach (self::$assets["Assets"]["js"] as $file) {
                        $asset = self::$dir . "js/" . $file;
                        echo '<script src="' . $asset . '"></script>';
                    }
                    break;
            }
        }
    }
    public static function GetAssetsArray()
    {
        return self::$assets["Assets"];
    }
}
FileManagement::DetectAssets();
?>