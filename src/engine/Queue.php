<?php
define(COORDINATE_FILE_PATH, realpath(dirname(__FILE__) . '/../coordinates.txt'));
define(MAX_FILE_LINES, 450);
require_once 'Coordinate.php';
/**
 * This class manages a list of coordinates
 *
 * @author jturner
 */
class Queue {

    /**
     *
     * @var array<Coordinate>
     */
    private $Buffer;
    
    private function LoadQueue() {
        //TODO: remove hard coded filepath
        $file_handle = fopen(COORDINATE_FILE_PATH, 'r');

        while (!feof($file_handle)) {
            $line = fgetcsv($file_handle, 1024);
            $this->Buffer[] = new Coordinate($line[0], $line[1], $line[2]);
        }
        fclose($file_handle);
    }

    function __construct() {
        $this->Buffer = array();
        $this->LoadQueue();
    }

    /**
     *
     * @param type $timelimit
     * @return type 
     */
    public function Pop($timelimit = null) {
        if($timelimit == null){
            return array_shift($this->Buffer);
        }
        
        foreach($this->Buffer as $buffer){
            if($buffer->Timestamp > $timelimit){
                return $buffer;
            }
        }
        
        return null;
    }
    
    public function Push($lat, $lon, $timestamp){
        if(count($this->Buffer) >= MAX_FILE_LINES){
            $buffer = "";
            $array = array_slice($this->Buffer, MAX_FILE_LINES * -1);
            foreach($array as $loc){
                $buffer .= "$loc->Latitude, $loc->Longitude, $loc->Timestamp\n";
            }
            file_put_contents(COORDINATE_FILE_PATH, trim($buffer));
        }
         file_put_contents(COORDINATE_FILE_PATH, "\n$lat, $lon, $timestamp", FILE_APPEND);
    }

}

?>
