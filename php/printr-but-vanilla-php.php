<?php
function MakeArray($processArray, $processLoopNumber = null)
{
    $processLoopNumber = $processLoopNumber;
    if (isset($processLoopNumber)) {
        $processLoopNumber += 1;
    } else {
        $processLoopNumber = 0;
    }
    if (isset($processArray) && is_array($processArray)) {
        foreach ($processArray as $key => $value) {
            if (is_array($value)) {
                $key = (is_int($key)) ? $key : "\"$key\"";
                $key = "[" . $key . "]";
                echo Space($processLoopNumber);
                echo $key . " => Array<br>";
                echo Space($processLoopNumber + 2);
                echo "(<br>";
                MakeArray($value, $processLoopNumber + 3);
                echo Space($processLoopNumber);
                echo ")";
            } else {
                $key = (is_int($key)) ? $key : "\"$key\"";
                $key = "[" . $key . "]";
                $value = (is_int($value)) ? $value : "\"$value\"";
                echo Space($processLoopNumber);
                echo $key . " => " . $value;
            }
            echo "<br>";
        }
    }
}
?>
