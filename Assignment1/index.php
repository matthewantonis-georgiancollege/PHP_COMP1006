<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gas Law Calculator</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Pressure P: <input type="text" name="pressure"><br>
        Length: <input type="text" name="length"><br>
        Width: <input type="text" name="width"><br>
        Height: <input type="text" name="height"><br>
        Temperature in Celsius: <input type="text" name="temperature"><br>
        <input type="submit">
    </form>
    <?php
        if ($_POST) {
            // define constant
            define("R", 8.314);

            // Get data from form inputs
            $p = floatval($_POST["pressure"]);
            $length = floatval($_POST["length"]);
            $width = floatval($_POST["width"]);
            $height = floatval($_POST["height"]);
            $temp = floatval($_POST["temperature"]);

            // Calculate volume
            $v = $length * $width * $height;

            // Convert temperature to Kelvin
            $t = $temp + 273.14;

            // Calculate number of moles
            $n = $p * $v / (R * $t);
            echo "Initial value for moles: " . $n . "<br>";

            // Round up to nearest whole number
            $n_rounded = ceil($n);
            echo "Rounded moles: " . $n_rounded . "<br>";

            // Turn odd into even and vice versa
            if ($n_rounded % 2 == 0) {
                $n_rounded += 1;
            } else {
                $n_rounded -= 1;
            }

            echo "Final number of moles (even if odd, odd if even): " . $n_rounded;
        }
    ?>
</body>
</html>
