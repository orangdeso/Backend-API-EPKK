<?php
require('koneksi.php');
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        
        // Mengecek apakah id ada di dalam tabel user
        $queryCheckUser = "SELECT * FROM `penggunas` WHERE `id` = '$id'";
        $checkUserResult = mysqli_query($koneksi, $queryCheckUser);
        
        if (mysqli_num_rows($checkUserResult) > 0) {
            // Mengambil data user berdasarkan id
            $queryGetUser = "SELECT * FROM `penggunas` WHERE `id` = '$id'";
            $getUserResult = mysqli_query($koneksi, $queryGetUser);
            
            $response["kode"] = 1;
            $response["pesan"] = "Data Tersedia";
            $response["data"] = mysqli_fetch_assoc($getUserResult);
        } else {
            $response["kode"] = 0;
            $response["pesan"] = "Data User tidak ditemukan";
        }
    } else {
        $response["kode"] = 0;
        $response["pesan"] = "ID User tidak ditemukan";
    }
} else {
    $response["kode"] = 0;
    $response["pesan"] = "Metode HTTP yang digunakan bukan POST";
}

echo json_encode($response);
mysqli_close($koneksi);
?>
