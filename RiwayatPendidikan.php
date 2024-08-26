<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['id_user'];

    $perintah = "SELECT * FROM laporan_pendidikan_n_keterampilan WHERE id_user = '$idUser' 
                ORDER BY id_pokja2_bidang1 DESC";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F["id_pokja2_bidang1"] = $ambil->id_pokja2_bidang1;
            $F['warga_buta'] = $ambil->warga_buta;
            $F['kel_belajarA'] = $ambil->kel_belajarA;
            $F['warga_belajarA'] = $ambil->warga_belajarA;
            $F['kel_belajarB'] = $ambil->kel_belajarB;
            $F['warga_belajarB'] = $ambil->warga_belajarB;
            $F['kel_belajarC'] = $ambil->kel_belajarC;
            $F['warga_belajarC'] = $ambil->warga_belajarC;
            $F['kel_belajarKF'] = $ambil->kel_belajarKF;
            $F['warga_belajarKF'] = $ambil->warga_belajarKF;
            $F['paud'] = $ambil->paud;
            $F['taman_bacaan'] = $ambil->taman_bacaan;
            $F['jumlah_klp'] = $ambil->jumlah_klp;
            $F['jumlah_ibu_peserta'] = $ambil->jumlah_ibu_peserta;
            $F['jumlah_ape'] = $ambil->jumlah_ape;
            $F['jumlah_kel_simulasi'] = $ambil->jumlah_kel_simulasi;
            $F['KF'] = $ambil->KF;
            $F['paud_tutor'] = $ambil->paud_tutor;
            $F['BKB'] = $ambil->BKB;
            $F['koperasi'] = $ambil->koperasi;
            $F['ketrampilan'] = $ambil->ketrampilan;
            $F['LP3PKK'] = $ambil->LP3PKK;
            $F['TP3PKK'] = $ambil->TP3PKK;
            $F['damas_pkk'] = $ambil->damas_pkk;
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
