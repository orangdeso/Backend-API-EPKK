<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['id_user'];
    $perintah = "SELECT * FROM laporan_penghayatan_n_pengamalan WHERE id_user = '$idUser' 
                ORDER BY id_pokja1_bidang1 DESC";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F["id_pokja1_bidang1"] = $ambil->id_pokja1_bidang1;
            $F["jumlah_kel_simulasi1"] = $ambil->jumlah_kel_simulasi1;
            $F["jumlah_anggota1"] = $ambil->jumlah_anggota1;
            $F["jumlah_kel_simulasi2"] = $ambil->jumlah_kel_simulasi2;
            $F["jumlah_anggota2"] = $ambil->jumlah_anggota2;
            $F["jumlah_kel_simulasi3"] = $ambil->jumlah_kel_simulasi3;
            $F["jumlah_anggota3"] = $ambil->jumlah_anggota3;
            $F["jumlah_kel_simulasi4"] = $ambil->jumlah_kel_simulasi4;
            $F["jumlah_anggota4"] = $ambil->jumlah_anggota4;
            $F["status"] = $ambil->status;
            $F['tanggal'] = $ambil->tanggal;
            $F['catatan'] = $ambil->catatan;
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
