<?php

include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_whatsapp = $_POST['no_whatsapp'];

    $koneksi->autocommit(false);
    try {
        $result = $koneksi->query("SELECT * FROM penggunas WHERE no_whatsapp = '$no_whatsapp'");
        $check = mysqli_affected_rows($koneksi);
        if ($check > 0) {
            $response['kode'] = 1;
            $response['pesan'] = "No whatsapp tersedia";
        } else {
            $response['kode'] = 2;
            $response['pesan'] = "No whatsapp tidak tersedia";
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
