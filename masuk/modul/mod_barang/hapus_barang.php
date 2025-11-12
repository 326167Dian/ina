<?php
include "../../../configurasi/koneksi.php";

$module = $_GET['module'];
$act = $_GET['act'];
$count = $_POST['check'];

for ($i = 0; $i < count($count); $i++) {
    // echo $count[$i] . '<br>';

    mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM barang WHERE kd_barang = '$count[$i]'");
}

header('location:../../media_admin.php?module=barang');
