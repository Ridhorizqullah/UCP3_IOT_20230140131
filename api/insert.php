<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Sesuaikan dengan user dan password XAMPP Anda (default: root dan kosong)
$conn = new mysqli("localhost", "root", "", "iot_db");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Koneksi database gagal: " . $conn->connect_error]));
}

// Mendapatkan data JSON dari body request (Postman)
$data = json_decode(file_get_contents("php://input"));

if (isset($data->datasensorreport)) {
    // Jika mengirimkan seluruh JSON sekalian (seperti di soal teks.md)
    $sensorArray = $data->datasensorreport[0]->sensordata;
    $inserted = 0;
    
    $stmt = $conn->prepare("INSERT INTO sensor_data (sensor_id, timestamp, temperature, humidity, pressure, latitude, longitude, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach($sensorArray as $item) {
        $sensor_id = $item->sensor_id ?? '1';
        $time_formatted = date('Y-m-d H:i:s', strtotime($item->timestamp));
        $temperature = $item->temperature;
        $humidity = $item->humidity;
        $pressure = $item->pressure;
        $latitude = $item->location->latitude ?? 0;
        $longitude = $item->location->longitude ?? 0;
        $status = $item->status ?? 'active';
        
        $stmt->bind_param("ssddddds", $sensor_id, $time_formatted, $temperature, $humidity, $pressure, $latitude, $longitude, $status);
        if($stmt->execute()) {
            $inserted++;
        }
    }
    $stmt->close();
    echo json_encode(["status" => "success", "message" => "$inserted record berhasil disimpan."]);

} elseif (isset($data->temperature) && isset($data->humidity)) {
    // Jika mengirimkan single object sensor per data dari Postman
    $sensor_id = $data->sensor_id ?? '1';
    $timestamp = $data->timestamp ?? date('Y-m-d H:i:s');
    $time_formatted = date('Y-m-d H:i:s', strtotime($timestamp));
    $temperature = $data->temperature;
    $humidity = $data->humidity;
    $pressure = $data->pressure;
    $latitude = $data->location->latitude ?? 0;
    $longitude = $data->location->longitude ?? 0;
    $status = $data->status ?? 'active';

    $stmt = $conn->prepare("INSERT INTO sensor_data (sensor_id, timestamp, temperature, humidity, pressure, latitude, longitude, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddddds", $sensor_id, $time_formatted, $temperature, $humidity, $pressure, $latitude, $longitude, $status);

    if($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "1 data berhasil disimpan."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan data."]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap atau format salah."]);
}

$conn->close();
?>
