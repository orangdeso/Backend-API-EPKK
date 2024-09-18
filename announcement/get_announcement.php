<?php
header('Content-Type: application/json');
require '../config/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10; 
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $offset = ($page - 1) * $limit;

    $perintah = "SELECT * FROM pengumumen WHERE CONCAT(YEAR(tanggalPengumuman), '/', 
                MONTH(tanggalPengumuman)) = CONCAT(YEAR(NOW()), '/', MONTH(NOW())) 
                ORDER BY id DESC 
                LIMIT $limit OFFSET $offset";

    $eksekusi = mysqli_query($koneksi, $perintah);

    if ($eksekusi) {
        if (mysqli_num_rows($eksekusi) > 0) {
            http_response_code(200); // Mengatur kode status HTTP menjadi 200 OK
            $response["statusCode"] = 200;
            $response["message"] = "Successfully fetched all Announcement!";
            $response["content"] = array();
            $response["content"]["data"] = array(); // Menyimpan data pengumuman di dalam content
            $response["error"] = null; // Tidak ada error

            while ($ambil = mysqli_fetch_assoc($eksekusi)) {
                $F = array(
                    "id" => $ambil['id'],
                    "judulPengumuman" => $ambil['judulPengumuman'],
                    "deskripsiPengumuman" => $ambil['deskripsiPengumuman'],
                    "tempatPengumuman" => $ambil['tempatPengumuman'],
                    "tanggalPengumuman" => $ambil['tanggalPengumuman'],
                    "updated_at" => $ambil['updated_at'],
                    "created_at" => $ambil['created_at']
                );
                array_push($response["content"]["data"], $F);
            }

            $countQuery = "SELECT COUNT(*) as total FROM pengumumen WHERE CONCAT(YEAR(tanggalPengumuman), '/', 
                         MONTH(tanggalPengumuman)) = CONCAT(YEAR(NOW()), '/', MONTH(NOW()))";
            $countResult = mysqli_query($koneksi, $countQuery);
            $totalData = mysqli_fetch_assoc($countResult)['total'];

            // Tambahkan informasi pagination ke dalam content
            $response["content"]["totalData"] = $totalData;
            $response["content"]["totalPage"] = ceil($totalData / $limit);
        } else {
            http_response_code(404); // Mengatur kode status HTTP menjadi 404 Not Found
            $response["statusCode"] = 404;
            $response["message"] = "Data Announcement not found!";
            $response["content"] = [];
            $response["error"] = null; 
        }
    } else {
        http_response_code(500); // Mengatur kode status HTTP menjadi 500 Internal Server Error
        $response["statusCode"] = 500;
        $response["message"] = "Internal Server Error";
        $response["content"] = [];
        $response["error"] = array(
            "code" => mysqli_errno($koneksi), // Kode error dari MySQL
            "message" => mysqli_error($koneksi) // Pesan error dari MySQL
        );
    }
} else {
    http_response_code(405); // Metode tidak diizinkan
    $response["statusCode"] = 405;
    $response["message"] = "Method not permitted";
    $response["content"] = [];
    $response["error"] = array(
        "code" => 405,
        "message" => "Only the GET method is allowed"
    );
}

echo json_encode($response);
mysqli_close($koneksi);