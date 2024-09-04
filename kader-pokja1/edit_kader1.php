<?php
header('Content-Type: application/json');
require("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Mendapatkan data input dari request PUT dalam format JSON
    parse_str(file_get_contents("php://input"), $_PUT);
    $PKBN = $_PUT['PKBN'];
    $PKDRT = $_PUT['PKDRT'];
    $pola_asuh = $_PUT['pola_asuh'];
    $id = $_PUT['id_kader_pokja1'];

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $updated_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "UPDATE laporan_kader_pokja1 SET PKBN = '$PKBN', PKDRT = '$PKDRT', pola_asuh = '$pola_asuh', 
                    catatan = '', status = 'Proses', updated_at = '$updated_at' WHERE id_kader_pokja1 = '$id'";

        $result = mysqli_query($koneksi, $query);
        $check = mysqli_affected_rows($koneksi);

        if ($check > 0) {
            $selectQuery = "SELECT * FROM laporan_kader_pokja1 WHERE id_kader_pokja1 = '$id'";
            $selectResult = mysqli_query($koneksi, $selectQuery);
            $data = mysqli_fetch_assoc($selectResult);

            $response['kode'] = 1;
            $response['message'] = "Data laporan Kader Pokja I berhasil diupdate";
            $response['data'] = $data;
        } else {
            $response['kode'] = 0;
            $response['message'] = "Data gagal diupdate";
        }
    } catch (Exception $e) {
        $response['kode'] = 0;
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}
?>
