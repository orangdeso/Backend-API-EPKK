<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $perintah = "SELECT id_detail_pokja1 FROM detail_pokja";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F["id_detail_pokja1"] = $ambil->id_detail_pokja1;
            // $F["bidang"] = $ambil->bidang;
            // $F["bidang1"] = $ambil->bidang1;
            // $F["bidang2"] = $ambil->bidang2;
            // $F["bidang3"] = $ambil->bidang3;

            array_push($response["data"], $F);
        }
    } else {
        $response["kode"] = 0;
        $response["message"] = "Data Tidak Tersedia";
        $response["data"] = null;
    }
}
echo json_encode($response);
mysqli_close($koneksi);
