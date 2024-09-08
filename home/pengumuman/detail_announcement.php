<?php
header('Content-Type: application/json');
require("../../koneksi.php");

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $perintah = "SELECT * FROM pengumumen WHERE id = '$id'";
        $eksekusi = mysqli_query($koneksi, $perintah);
        $cek = mysqli_num_rows($eksekusi);

        if ($eksekusi) {
            if ($cek > 0) {
                http_response_code(200); // Set HTTP status code to 200 OK
                $response["statusCode"] = 200;
                $response["message"] = "Successfully fetched detail Announcement!";
                $response["data"] = array();
                $response["error"] = null; // No error

                while ($ambil = mysqli_fetch_object($eksekusi)) {
                    $F = array(
                        "id" => $ambil->id,
                        "judulPengumuman" => $ambil->judulPengumuman,
                        "deskripsiPengumuman" => $ambil->deskripsiPengumuman,
                        "tempatPengumuman" => $ambil->tempatPengumuman,
                        "tanggalPengumuman" => $ambil->tanggalPengumuman,
                        "updated_at" => $ambil->updated_at,
                        "created_at" => $ambil->created_at
                    );

                    array_push($response["data"], $F);
                }
            } else {
                http_response_code(404); // Set HTTP status code to 404 Not Found
                $response["statusCode"] = 404;
                $response["message"] = "Data Announcement not found!";
                $response["data"] = [];
                $response["error"] = null; // No error, just no data
            }
        } else {
            http_response_code(500); // Set HTTP status code to 500 Internal Server Error
            $response["statusCode"] = 500;
            $response["message"] = "Internal Server Error, Query Error";
            $response["data"] = [];
            $response["error"] = array(
                "code" => mysqli_errno($koneksi), // MySQL error code
                "message" => mysqli_error($koneksi) // MySQL error message
            );
        }
    } else {
        http_response_code(400); // Set HTTP status code to 400 Bad Request
        $response["statusCode"] = 400;
        $response["message"] = "Parameter 'id' not found";
        $response["data"] = [];
        $response["error"] = array(
            "code" => 400,
            "message" => "Parameter 'id' is required for this request"
        );
    }
} else {
    http_response_code(405); // Set HTTP status code to 405 Method Not Allowed
    $response["statusCode"] = 405;
    $response["message"] = "Method not allowed";
    $response["data"] = [];
    $response["error"] = array(
        "code" => 405,
        "message" => "Only GET method is allowed"
    );
}

echo json_encode($response);
mysqli_close($koneksi);
?>
