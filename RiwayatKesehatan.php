<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['id_user'];
    $perintah = "SELECT * FROM laporan_bidang_kesehatan WHERE id_user = '$idUser' 
                ORDER BY id_laporan_sehat DESC";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F["id_laporan_sehat"] = $ambil->id_laporan_sehat;
            $F["jumlah_posyandu"] = $ambil->jumlah_posyandu;
            $F["jumlah_posyandu_iterasi"] = $ambil->jumlah_posyandu_iterasi;
            $F["jumlah_klp"] = $ambil->jumlah_klp;
            $F["jumlah_anggota"] = $ambil->jumlah_anggota;
            $F["jumlah_kartu_gratis"] = $ambil->jumlah_kartu_gratis;
            $F["catatan"] = $ambil->catatan;
            $F["status"] = $ambil->status;
            $F['tanggal'] = $ambil->tanggal;
            $F["waktu"] = $ambil->waktu;
            $F['id_user'] = $ambil->id_user;

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
