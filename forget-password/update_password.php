<?php

require("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Mendapatkan data input dari request PUT
    parse_str(file_get_contents("php://input"), $_PUT);
    $no_whatsapp = $_PUT["no_whatsapp"];
    $password = $_PUT["password"];

    // Enkripsi password menggunakan password_hash
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Menggunakan prepared statement untuk mencegah SQL injection
    $stmt = $koneksi->prepare("UPDATE penggunas SET password = ? WHERE no_whatsapp = ?");
    $stmt->bind_param("ss", $hashed_password, $no_whatsapp);
    $stmt->execute();

    $check = $stmt->affected_rows;

    if ($check > 0) {
        $response['kode'] = 1;
        $response["message"] = "Password berhasil dirubah";
    } else {
        $response["kode"] = 0;
        $response["message"] = "Data Tidak Tersedia";
    }

    echo json_encode($response);
    $stmt->close();
    $koneksi->close();
}
?>
