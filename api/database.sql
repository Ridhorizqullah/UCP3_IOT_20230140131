CREATE DATABASE IF NOT EXISTS iot_db;
USE iot_db;

CREATE TABLE IF NOT EXISTS sensor_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sensor_id VARCHAR(50),
    timestamp DATETIME,
    temperature FLOAT,
    humidity FLOAT,
    pressure FLOAT,
    latitude FLOAT,
    longitude FLOAT,
    status VARCHAR(50)
);
