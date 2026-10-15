<!DOCTYPE html>
<html>
<head>
    <title>Contoh Penggunaan UDF</title>
</head>
<body>

<h2>Operasi 2 Bilangan</h2>

<form method="post">
    Masukkan Bilangan Pertama:
    <input type="number" name="A" required><br><br>

    Masukkan Bilangan Kedua:
    <input type="number" name="B" required><br><br>

    <input type="submit" name="hitung" value="Hitung">
</form>

<?php

function jumlah($A, $B)
{
    return $A + $B;
}

function kurang($A, $B)
{
    return $A - $B;
}

function kali($A, $B)
{
    return $A * $B;
}

function bagi($A, $B)
{
    if ($B == 0) {
        return "Tidak dapat dibagi 0";
    }

    return $A / $B;
}

if (isset($_POST['hitung'])) {

    $A = $_POST['A'];
    $B = $_POST['B'];

    echo "<hr>";
    echo "Bilangan Pertama : " . $A . "<br>";
    echo "Bilangan Kedua : " . $B . "<br><br>";

    echo "Penjumlahan : " . jumlah($A, $B) . "<br>";
    echo "Pengurangan : " . kurang($A, $B) . "<br>";
    echo "Perkalian : " . kali($A, $B) . "<br>";
    echo "Pembagian : " . bagi($A, $B) . "<br>";
}

?>

</body>
</html>