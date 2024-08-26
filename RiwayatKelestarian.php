<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['id_user'];
    $perintah = "SELECT * FROM laporan_kelestarian_lingkungan_hidup WHERE id_user = '$idUser' 
                ORDER BY id_kelpangan DESC";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F["id_kelpangan"] = $ambil->id_kelpangan;
            $F["jamban"] = $ambil->jamban;
            $F["spal"] = $ambil->spal;
            $F["tps"] = $ambil->tps;
            $F["mck"] = $ambil->mck;
            $F["pdam"] = $ambil->pdam;
            $F["sumur"] = $ambil->sumur;
            $F["dll"] = $ambil->dll;
            $F["catatan"] = $ambil->catatan;
            $F['id_user'] = $ambil->id_user;
            $F['status'] = $ambil->status;
            $F['tanggal'] = $ambil->tanggal;
            $F['waktu'] = $ambil->waktu;

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
