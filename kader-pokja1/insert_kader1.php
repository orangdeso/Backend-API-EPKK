<?php
require("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $PKBN = $_POST['PKBN'];
    $PKDRT = $_POST['PKDRT'];
    $pola_asuh = $_POST['pola_asuh'];
    $user_id = $_POST['id_user'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        // Insert data ke dalam database
        $query = "INSERT INTO laporan_kader_pokja1 (PKBN, PKDRT, pola_asuh, status, tanggal, id_user, waktu, created_at) 
                  VALUES ('$PKBN', '$PKDRT', '$pola_asuh', 'Proses', '$tanggal', '$user_id', '$waktu', '$created_at')";

        $result = mysqli_query($koneksi, $query);
        $check = mysqli_affected_rows($koneksi);

        if ($check > 0) {
            // Jika data berhasil masuk, ambil data yang baru saja dimasukkan
            $selectQuery = "SELECT * FROM laporan_kader_pokja1 WHERE id_user = '$user_id' AND created_at = '$created_at'";
            $selectResult = mysqli_query($koneksi, $selectQuery);
            $data = mysqli_fetch_assoc($selectResult);

            $response['kode'] = 1;
            $response['message'] = "Data Masuk dan Ditemukan";
            $response['data'] = $data;
        } else {
            $response['kode'] = 0;
            $response['message'] = "Data Gagal Masuk";
        }
    } catch (Exception $e) {
        $response['kode'] = 0;
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}
?>
