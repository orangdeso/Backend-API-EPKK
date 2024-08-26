<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $passwordLama = $_POST['password_lama'];

    // Periksa apakah password lama sesuai dengan yang ada di database
    $perintahCekPasswordLama = "SELECT * FROM penggunas WHERE id = '$id' AND password = '$passwordLama'";
 
    $eksekusiCekPasswordLama = mysqli_query($koneksi, $perintahCekPasswordLama);

    if (mysqli_num_rows($eksekusiCekPasswordLama) > 0) {
        // Jika password lama sesuai, lakukan pembaruan password
        $perintahUpdatePassword = "UPDATE penggunas SET password = '$password' WHERE id = '$id'";
        $eksekusiUpdatePassword = mysqli_query($koneksi, $perintahUpdatePassword);

        if ($eksekusiUpdatePassword) {
            $response["kode"] = 1;
            $response["message"] = "Data berhasil diperbarui";
        } else {
            $response["kode"] = 0;
            $response["message"] = "Gagal memperbarui data";
        }
    } else {
        $response["kode"] = 0;
        $response["message"] = "Password lama tidak sesuai";
    }
} else {
    $response["kode"] = 0;
    $response["message"] = "Metode yang digunakan tidak valid";
}

echo json_encode($response);
mysqli_close($koneksi);
?>
