<?php
header('Content-Type: application/json');
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Memastikan bahwa ID dikirim melalui URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        date_default_timezone_set('Asia/Jakarta');
        $timestamp = time();
        $updated_at = date("Y-m-d H:i:s", $timestamp);
        $waktu = date("H:i", $timestamp);

        try {
            // Query untuk update data
            $query = "UPDATE laporan_kader_pokja1 SET catatan = '', status = 'Dibatalkan', updated_at = '$updated_at' 
                      WHERE id_kader_pokja1 = '$id'";

            $result = mysqli_query($koneksi, $query);
            $check = mysqli_affected_rows($koneksi);

            if ($check > 0) {
                $selectQuery = "SELECT * FROM laporan_kader_pokja1 WHERE id_kader_pokja1 = '$id'";
                $selectResult = mysqli_query($koneksi, $selectQuery);
                $data = mysqli_fetch_assoc($selectResult);

                $response['kode'] = 1;
                $response['message'] = "Data laporan Kader Pokja I Dibatalkan";
                $response['data'] = $data;
            } else {
                $response['kode'] = 0;
                $response['message'] = "Data gagal diupdate";
            }

        } catch (Exception $e) {
            $response['kode'] = 0;
            $response['message'] = $e->getMessage();
        }
    } else {
        $response['kode'] = 0;
        $response['message'] = "Parameter ID tidak ditemukan";
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}
?>
