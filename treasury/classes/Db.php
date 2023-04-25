<?php

namespace Classes;

use mysqli;
use Exception;

class Db
{
    public static $conn;
    public const DB_HO = "localhost";
    public const DB_US = "root";
    public const DB_PS = "";
    public const DB_NA = "epiz_33155713_treasury";
    
    public function __construct() 
    {
        try {
            self::$conn = new mysqli(DB::DB_HO, DB::DB_US, DB::DB_PS, DB::DB_NA);
        } catch (Exception $e) {
            echo "Connection failed: " . $e->getMessage();
        }
	}
}