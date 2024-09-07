<?php
header('Content-Type: application/json');
require("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$koneksi) {
        // Jika koneksi database gagal
        $response['kode'] = 0;
        $response['message'] = "Server sedang bermasalah, silakan coba lagi nanti.";
        echo json_encode($response);
        exit(); // Keluar dari script setelah mengirim respons
    }

    $PKBN = $_POST['PKBN'];
    $PKDRT = $_POST['PKDRT'];
    $pola_asuh = $_POST['pola_asuh'];
    $id_user = $_POST['id_user'];
    $tanggal = date('Y-m-d');
    $role = $_POST['role'];
    $role_bidang = $_POST['role_bidang'];

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        // Insert data ke dalam database
        $query = "INSERT INTO laporan_kader_pokja1 (PKBN, PKDRT, pola_asuh, status, tanggal, id_user, waktu, role, role_bidang, created_at) 
                  VALUES ('$PKBN', '$PKDRT', '$pola_asuh', 'Proses', '$tanggal', '$id_user', '$waktu', '$role', '$role_bidang', '$created_at')";

        $result = mysqli_query($koneksi, $query);
        $check = mysqli_affected_rows($koneksi);

        if ($check > 0) {
            // Jika data berhasil masuk, ambil data yang baru saja dimasukkan
            $selectQuery = "SELECT * FROM laporan_kader_pokja1 WHERE id_user = '$id_user' AND created_at = '$created_at'";
            $selectResult = mysqli_query($koneksi, $selectQuery);
            $data = mysqli_fetch_assoc($selectResult);

            $response['kode'] = 1;
            $response['message'] = "Berhasil upload laporan kader pokja I";
            $response['data'] = $data;
        } else {
            $response['kode'] = 0;
            $response['message'] = "Gagal upload laporan kader pokja I";
        }
    } catch (Exception $e) {
        $response['kode'] = 0;
        $response['message'] = "Server sedang bermasalah, silakan coba lagi nanti.";
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}
?>
