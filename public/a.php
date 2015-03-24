<?php

print_r($_POST);

echo "<br><br><br>-----Headerrs<br><br><br>";
foreach (getallheaders() as $name => $value) {
    echo "$name: $value\n";

}
echo "<br><br><br>--------------<br><br><br><br>";
print_r($_SERVER);