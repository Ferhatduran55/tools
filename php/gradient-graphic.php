<?php

function gradient($w = 100, $h = 100, $c = array('#FFFFFF', '#FF0000', '#00FF00', '#0000FF'), $hex = true)
{

    /*
Generates a gradient image

Author: Christopher Kramer

Parameters:
w: width in px
h: height in px
c: color-array with 4 elements:
    $c[0]:   top left color
    $c[1]:   top right color
    $c[2]:   bottom left color
    $c[3]:   bottom right color
   
if $hex is true (default), colors are hex-strings like '#FFFFFF' (NOT '#FFF')
if $hex is false, a color is an array of 3 elements which are the rgb-values, e.g.:
$c[0]=array(0,255,255);

*/

    $im = imagecreatetruecolor($w, $h);

    if ($hex) {  // convert hex-values to rgb
        for ($i = 0; $i <= 3; $i++) {
            $c[$i] = hex2rgb($c[$i]);
        }
    }

    $rgb = $c[0]; // start with top left color
    for ($x = 0; $x <= $w; $x++) { // loop columns
        for ($y = 0; $y <= $h; $y++) { // loop rows
            // set pixel color
            $col = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
            imagesetpixel($im, $x - 1, $y - 1, $col);
            // calculate new color 
            for ($i = 0; $i <= 2; $i++) {
                $rgb[$i] =
                    $c[0][$i] * (($w - $x) * ($h - $y) / ($w * $h)) +
                    $c[1][$i] * ($x     * ($h - $y) / ($w * $h)) +
                    $c[2][$i] * (($w - $x) * $y     / ($w * $h)) +
                    $c[3][$i] * ($x     * $y     / ($w * $h));
            }
        }
    }
    return $im;
}

function hex2rgb($hex)
{
    $rgb[0] = hexdec(substr($hex, 1, 2));
    $rgb[1] = hexdec(substr($hex, 3, 2));
    $rgb[2] = hexdec(substr($hex, 5, 2));
    return ($rgb);
}

// usage example

$image = gradient(random_int(0, 300), random_int(0, 300), array('#000000', '#FFFFFF', '#FF0000', '#0000FF'));

header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>