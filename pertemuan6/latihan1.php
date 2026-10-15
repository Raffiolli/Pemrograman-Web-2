<!DOCTYPE html>
<html>
<head>
    <title>Latihan 1 Array PHP</title>
</head>
<body>

<?php

$a[0] = 1;
$a[1] = 3;
$a[2] = 5;

$jumlah = count($a);

echo "Jumlah array a = $jumlah <br>";

$b["buah"] = "semangka";
$b["sayur"] = "wortel";
$b["daging"] = "ayam";
$b["utama"] = "nasi";

$jumlah = sizeof($b);

echo "Jumlah array b = $jumlah <br>";

?>

</body>
</html>