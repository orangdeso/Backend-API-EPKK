<?php
header('Content-Type: application/json');
require '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        date_default_timezone_set('Asia/Jakarta');
        $timestamp = time();
        $updated_at = date("Y-m-d H:i:s", $timestamp);

        try {
            // Query to update the data
            $query = "UPDATE laporan_kader_pokja1 SET catatan = '', status = 'Dibatalkan', updated_at = '$updated_at' 
                      WHERE uuid = '$id'";

            $result = mysqli_query($koneksi, $query);
            $check = mysqli_affected_rows($koneksi);

            if ($check > 0) {
                // Fetch the updated data
                $selectQuery = "SELECT * FROM laporan_kader_pokja1 WHERE uuid = '$id'";
                
                $selectResult = mysqli_query($koneksi, $selectQuery);
                $data = mysqli_fetch_assoc($selectResult);

                $response = [
                    'statusCode' => 200,
                    'message' => "Kader Pokja I report successfully cancelled",
                    'data' => [
                        "id" => $data['uuid'],
                        "status" => $data['status'],
                        "updated_at" => $data['updated_at'],
                    ],
                    'error' => null
                ];
            } else {
                $response = [
                    'statusCode' => 404,
                    'message' => "Failed to update Kader Pokja I report. Report not found or no changes detected.",
                    'data' => null,
                    'error' => null
                ];
            }

        } catch (Exception $e) {
            $response = [
                'statusCode' => 500,
                'message' => $e->getMessage(),
                'data' => null,
                'error' => ['message' => 'An error occurred while updating the report.']
            ];
        }
    } else {
        $response = [
            'statusCode' => 400,
            'message' => "Parameter ID not found",
            'data' => null,
            'error' => ['message' => 'Missing report ID parameter']
        ];
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}
?>
