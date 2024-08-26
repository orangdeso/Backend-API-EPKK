<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['id_user'];

    $perintah = "SELECT * FROM laporan_umum WHERE id_user = '$idUser' 
                ORDER BY id_laporan_umum DESC";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F['id_laporan_umum'] = $ambil->id_laporan_umum;
            $F['dusun_lingkungan'] = $ambil->dusun_lingkungan;
            $F['PKK_RW'] = $ambil->PKK_RW;
            $F['desa_wisma'] = $ambil->desa_wisma;
            $F['KRT'] = $ambil->KRT;
            $F['KK'] = $ambil->KK;
            $F['jiwa_laki'] = $ambil->jiwa_laki;
            $F['jiwa_perempuan'] = $ambil->jiwa_perempuan;
            $F['anggota_laki'] = $ambil->anggota_laki;
            $F['anggota_perempuan'] = $ambil->anggota_perempuan;
            $F['umum_laki'] = $ambil->umum_laki;
            $F['umum_perempuan'] = $ambil->umum_perempuan;
            $F['khusus_laki'] = $ambil->khusus_laki;
            $F['khusus_perempuan'] = $ambil->khusus_perempuan;
            $F['honorer_laki'] = $ambil->honorer_laki;
            $F['honorer_perempuan'] = $ambil->honorer_perempuan;
            $F['bantuan_laki'] = $ambil->bantuan_laki;
            $F['bantuan_perempuan'] = $ambil->bantuan_perempuan;
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
