<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah_posyandu = $_POST['jumlah_posyandu'];
    $jumlah_posyandu_iterasi = $_POST['jumlah_posyandu_iterasi'];
    $jumlah_klp = $_POST['jumlah_klp'];
    $jumlah_anggota = $_POST['jumlah_anggota'];
    $jumlah_kartu_gratis = $_POST['jumlah_kartu_gratis'];
    $user_id = $_POST['id_user'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "INSERT INTO laporan_bidang_kesehatan (jumlah_posyandu, jumlah_posyandu_iterasi, 
                    jumlah_klp, jumlah_anggota, jumlah_kartu_gratis, 
                    status, tanggal, id_user, waktu, created_at) 
        VALUES ('$jumlah_posyandu', '$jumlah_posyandu_iterasi', '$jumlah_klp', '$jumlah_anggota', 
                    '$jumlah_kartu_gratis', 'Proses', '$tanggal', '$user_id', '$waktu', '$created_at')";

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
