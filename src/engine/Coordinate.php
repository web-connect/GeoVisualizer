<?php
class Coordinate{
    public $Latitude;
    public $Longitude;
    public $Timestamp;
    
    public function __construct($lat, $long, $timestamp) {
        $this->Latitude = $lat;
        $this->Longitude = $long;
        $this->Timestamp = $timestamp;
    }
}
?>
