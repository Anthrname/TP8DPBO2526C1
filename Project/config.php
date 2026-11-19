<?php
/**
 * Konfigurasi Database
 * Tugas Praktikum 8 DPBO 2024/2025
 * Najib Nurohman - 2509653 - C1
 */

class Config {
    public static $hostname = "localhost";
    public static $username = "root";
    public static $password = "";
    public static $dbname   = "tp_mvc25";
}

// Kompatibilitas variabel global jika diperlukan
$hostname = Config::$hostname;
$username = Config::$username;
$password = Config::$password;
$dbname   = Config::$dbname;
?>
