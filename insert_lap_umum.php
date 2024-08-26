<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dusun_lingkungan = $_POST['dusun_lingkungan'];
    $PKK_RW = $_POST['PKK_RW'];
    $desa_wisma = $_POST['desa_wisma'];
    $KRT = $_POST['KRT'];
    $KK = $_POST['KK'];
    $jiwa_laki = $_POST['jiwa_laki'];
    $jiwa_perempuan = $_POST['jiwa_perempuan'];
    $anggota_laki = $_POST['anggota_laki'];
    $anggota_perempuan = $_POST['anggota_perempuan'];
    $umum_laki = $_POST['umum_laki'];
    $umum_perempuan = $_POST['umum_perempuan'];
    $khusus_laki = $_POST['khusus_laki'];
    $khusus_perempuan = $_POST['khusus_perempuan'];
    $honorer_laki = $_POST['honorer_laki'];
    $honorer_perempuan = $_POST['honorer_perempuan'];
    $bantuan_laki = $_POST['bantuan_laki'];
    $bantuan_perempuan = $_POST['bantuan_perempuan'];

    $user_id = $_POST['id_user'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "INSERT INTO laporan_umum (dusun_lingkungan, PKK_RW, desa_wisma, 
                    KRT, KK, jiwa_laki, jiwa_perempuan, anggota_laki, anggota_perempuan, 
                    umum_laki, umum_perempuan, khusus_laki, khusus_perempuan,
                    honorer_laki, honorer_perempuan, bantuan_laki, bantuan_perempuan,
                    status, tanggal, id_user, waktu, created_at) 
        VALUES ('$dusun_lingkungan', '$PKK_RW', '$desa_wisma', '$KRT', 
                    '$KK', '$jiwa_laki', '$jiwa_perempuan', '$anggota_laki', 
                    '$anggota_perempuan', '$umum_laki', '$umum_perempuan',
                    '$khusus_laki', '$khusus_perempuan', '$honorer_laki',
                    '$honorer_perempuan', '$bantuan_laki', '$bantuan_perempuan',   
                    'Proses', '$tanggal', '$user_id', '$waktu', '$created_at')";

        $result = mysqli_query($koneksi, $query);
        $check = mysqli_affected_rows($koneksi);

        if ($check > 0) {
            $response['kode'] = 1;
            $response['message'] = "Data Masuk";
            $response['data'] = [
                'Berhasil' => $check
            ];
        } else {
            $response['kode'] = 0;
            $response['message'] = "Data Gagal Masuk";
        }

        // echo 'Data berhasil disimpan!';
    } catch (Exception $e) {
        $response['kode'] = 0;
        $response['message'] = $e->getMessage();
    }
    echo json_encode($response);
    mysqli_close($koneksi);
}
