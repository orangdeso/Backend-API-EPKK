<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['id_user'];

    $perintah = "SELECT * FROM laporan_pengembangan_kehidupan WHERE id_user = '$idUser' 
                ORDER BY id_pokja2_bidang2 DESC";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F['id_pokja2_bidang2'] = $ambil->id_pokja2_bidang2;
            $F['jumlah_kelompok_pemula'] = $ambil->jumlah_kelompok_pemula;
            $F['jumlah_peserta_pemula'] = $ambil->jumlah_peserta_pemula;
            $F['jumlah_kelompok_madya'] = $ambil->jumlah_kelompok_madya;
            $F['jumlah_peserta_madya'] = $ambil->jumlah_peserta_madya;
            $F['jumlah_kelompok_utama'] = $ambil->jumlah_kelompok_utama;
            $F['jumlah_peserta_utama'] = $ambil->jumlah_peserta_utama;
            $F['jumlah_kelompok_mandiri'] = $ambil->jumlah_kelompok_mandiri;
            $F['jumlah_peserta_mandiri'] = $ambil->jumlah_peserta_mandiri;
            $F['jumlah_kelompok_hukum'] = $ambil->jumlah_kelompok_hukum;
            $F['jumlah_peserta_hukum'] = $ambil->jumlah_peserta_hukum;
            $F['catatan'] = $ambil->catatan;
            $F["status"] = $ambil->status;
            $F['tanggal'] = $ambil->tanggal;
            $F['waktu'] = $ambil->waktu;
            $F["created_at"] = $ambil->created_at;
            $F["updated_at"] = $ambil->updated_at;

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
