<?php

namespace Kalkulator;

// Trait 
trait OperasiDasar
{
    public function penjumlahan($a, $b)
    {
        return $a + $b;
    }

    public function pengurangan($a, $b)
    {
        return $a - $b;
    }

    public function perkalian($a, $b)
    {
        return $a * $b;
    }

    public function pembagian($a, $b)
    {
        if ($b != 0) {
            return $a / $b;
        } else {
            return "Error: tidak bisa dibagi dengan 0!";
        }
    }
}

// Abstract class 
abstract class KalkulatorAbstrak
{
    protected $hasil;

    abstract public function hitung($a, $b, $operasi);
}

// Class Kalkulator dengan inheritance dari KalkulatorAbstrak
class Kalkulator extends KalkulatorAbstrak
{
    use OperasiDasar;

    public function hitung($a, $b, $operasi)
    {
        switch ($operasi) {
            case 'Tambah':
                $this->hasil = $this->penjumlahan($a, $b);
                break;
            case 'Kurang':
                $this->hasil = $this->pengurangan($a, $b);
                break;
            case 'Kali':
                $this->hasil = $this->perkalian($a, $b);
                break;
            case 'Bagi':
                // Mengatasi pembagian dengan nol
                $this->hasil = ($b != 0) ? $this->pembagian($a, $b) : "Error: tidak bisa dibagi dengan 0!";
                break;
            default:
                $this->hasil = "Operasi tidak valid";
        }
    }

    // Magic method
    public function __toString()
    {
        return "Hasil: " . $this->hasil;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $kalkulator = new Kalkulator();

    $angka1 = isset($_POST['angka1']) ? floatval($_POST['angka1']) : 0;
    $angka2 = isset($_POST['angka2']) ? floatval($_POST['angka2']) : 0;
    $operasi = isset($_POST['operasi']) ? $_POST['operasi'] : 'Tambah';

    $kalkulator->hitung($angka1, $angka2, $operasi);
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Sederhana</title>
</head>

<body>
    <h1>Kalkulator Sederhana</h1>
    <form method="post" action="">
        <label for="angka1">Angka 1 :</label>
        <input type="text" name="angka1" required>

        <label for="operasi">Pilih operasi:</label>
        <select name="operasi">
            <option value="Tambah"> + </option>
            <option value="Kurang"> - </option>
            <option value="Kali"> * </option>
            <option value="Bagi"> / </option>
        </select>

        <label for="angka2">Angka 2:</label>
        <input type="text" name="angka2" required>

        <button type="submit">Hitung</button>
    </form>

    <?php
    // Menampilkan hasil perhitungan jika formulir sudah dikirim
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<p>' . $kalkulator . '</p>';
    }
    ?>
</body>

</html>