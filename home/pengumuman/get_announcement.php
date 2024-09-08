<?php
header('Content-Type: application/json');
require("../../koneksi.php");

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $perintah = "SELECT * FROM pengumumen WHERE CONCAT(YEAR(tanggalPengumuman), '/', 
                MONTH(tanggalPengumuman)) = CONCAT(YEAR(NOW()), '/', MONTH(NOW())) 
                ORDER BY id DESC";
    $eksekusi = mysqli_query($koneksi, $perintah);

    if ($eksekusi) {
        if (mysqli_num_rows($eksekusi) > 0) {
            http_response_code(200); // Mengatur kode status HTTP menjadi 200 OK
            $response["statusCode"] = 200;
            $response["message"] = "Successfully fetched all Announcement!";
            $response["data"] = array();
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
                array_push($response["data"], $F);
            }
        } else {
            http_response_code(404); // Mengatur kode status HTTP menjadi 404 Not Found
            $response["statusCode"] = 404;
            $response["message"] = "Data Announcement not found!";
            $response["data"] = [];
            $response["error"] = null; // Tidak ada error, hanya tidak ada data
        }
    } else {
        http_response_code(500); // Mengatur kode status HTTP menjadi 500 Internal Server Error
        $response["statusCode"] = 500;
        $response["message"] = "Internal Server Error";
        $response["data"] = [];
        $response["error"] = array(
            "code" => mysqli_errno($koneksi), // Kode error dari MySQL
            "message" => mysqli_error($koneksi) // Pesan error dari MySQL
        );
    }
} else {
    http_response_code(405); // Metode tidak diizinkan
    $response["statusCode"] = 405;
    $response["message"] = "Method not permitted";
    $response["data"] = [];
    $response["error"] = array(
        "code" => 405,
        "message" => "Only the GET method is allowed"
    );
}

echo json_encode($response);
mysqli_close($koneksi);

// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
//     $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 2; // Jumlah data per halaman
//     $offset = ($page - 1) * $limit; // Hitung offset

//     // Hitung total records
//     $total_records_query = "SELECT COUNT(*) as total FROM pengumumen 
//                             WHERE CONCAT(YEAR(tanggalPengumuman), '/', MONTH(tanggalPengumuman)) = CONCAT(YEAR(NOW()), '/', MONTH(NOW()))";
//     $total_records_result = mysqli_query($koneksi, $total_records_query);
//     $total_records_row = mysqli_fetch_assoc($total_records_result);
//     $total_records = $total_records_row['total'];

//     // Hitung total pages
//     $total_pages = ceil($total_records / $limit);

//     // Query untuk mendapatkan data dengan paginasi
//     $perintah = "SELECT * FROM pengumumen 
//                  WHERE CONCAT(YEAR(tanggalPengumuman), '/', MONTH(tanggalPengumuman)) = CONCAT(YEAR(NOW()), '/', MONTH(NOW())) 
//                  ORDER BY id DESC 
//                  LIMIT $limit OFFSET $offset";
//     $eksekusi = mysqli_query($koneksi, $perintah);

//     if ($eksekusi) {
//         if (mysqli_num_rows($eksekusi) > 0) {
//             $response["kode"] = 1;
//             $response["message"] = "Data Tersedia";
//             $response["current_page"] = $page;
//             $response["total_pages"] = $total_pages;
//             $response["total_records"] = $total_records;
//             $response["records_per_page"] = $limit;
//             $response["data"] = array();

//             while ($ambil = mysqli_fetch_assoc($eksekusi)) {
//                 $F = array(
//                     "id" => $ambil['id'],
//                     "judulPengumuman" => $ambil['judulPengumuman'],
//                     "deskripsiPengumuman" => $ambil['deskripsiPengumuman'],
//                     "tempatPengumuman" => $ambil['tempatPengumuman'],
//                     "tanggalPengumuman" => $ambil['tanggalPengumuman'],
//                     "updated_at" => $ambil['updated_at'],
//                     "created_at" => $ambil['created_at']
//                 );
//                 array_push($response["data"], $F);
//             }
//         } else {
//             $response["kode"] = 0;
//             $response["message"] = "Data Tidak Tersedia";
//             $response["data"] = null;
//         }
//     } else {
//         $response["kode"] = 0;
//         $response["message"] = "Query Error: " . mysqli_error($koneksi);
//         $response["data"] = null;
//     }
// }

// echo json_encode($response);
// mysqli_close($koneksi);

