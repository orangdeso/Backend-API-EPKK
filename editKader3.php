<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pangan = $_POST['pangan'];
    $sandang = $_POST['sandang'];
    $tata_laksana_rumah = $_POST['tata_laksana_rumah'];
    $user_id = $_POST['id_kader_pokja3'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $updated_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "UPDATE laporan_kader_pokja3 SET pangan = '$pangan', sandang = '$sandang', 
                    tata_laksana_rumah = '$tata_laksana_rumah', catatan = '', 
                    status = 'Proses', updated_at = '$updated_at' WHERE id_kader_pokja3 = '$user_id'";

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
