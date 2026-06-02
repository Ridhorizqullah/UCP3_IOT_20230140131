<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Sesuaikan dengan user dan password XAMPP Anda
$conn = new mysqli("localhost", "root", "", "iot_db");

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Koneksi database gagal: " . $conn->connect_error]));
}

// Mengambil data dari tabel, mengurutkan berdasarkan waktu (terlama ke terbaru)
$result = $conn->query("SELECT * FROM sensor_data ORDER BY timestamp ASC");
$data = [];

while($row = $result->fetch_assoc()) {
    $data[] = [
        "sensor_id" => $row['sensor_id'],
        "Temperature" => (float)$row['temperature'],
        "Humidity" => (float)$row['humidity'],
        "Pressure" => (float)$row['pressure'],
        "timestamp" => $row['timestamp']
    ];
}

// Kirimkan response JSON dengan format yang akan diterima Chart.js kita
echo json_encode(["success" => true, "data" => $data]);
$conn->close();
?>
