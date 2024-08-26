<?php

// header('Content-Type: application/json/; charset=utf-8');
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_otp = $_POST['kode_otp'];

    $koneksi->autocommit(false);
    try {
        $result = $koneksi->query("SELECT * FROM penggunas WHERE kode_otp = '$kode_otp'");
        $check = mysqli_affected_rows($koneksi);
        if ($check > 0) {
            $response['kode'] = 1;
            $response['pesan'] = "Berhasil Login";
        } else {
            $response['kode'] = 2;
            $response['pesan'] = "Gagal Login";
        }

        $koneksi->commit();

        // $response['data'] = $data;
    } catch (Exception $e) {
        $response['kode'] = 0;
        $response['pesan'] = $e->getMessage();
        //$response['data'] = null;
        $koneksi->rollback();
    }
    echo json_encode($response);
    mysqli_close($koneksi);
}
