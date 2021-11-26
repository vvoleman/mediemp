<?php

namespace App\Service\File;

use App\Service\Util\TimeTrackerTrait;
use Doctrine\DBAL\Connection;
use App\Service\File\BulkInsert\BulkInsert;

class RemoteFileReaderService {
    use TimeTrackerTrait;

    private $fileHandle;
    private Connection $conn;
    private array $buffer = [];
    private int $counter = 0;

    public function __construct(Connection $conn) {
        $this->conn = $conn;
        $this->conn->getConfiguration()->setSQLLogger(null);
    }

    public function readToFile(string $url, string $saveTo) {
        set_time_limit(0);

        # Open the file for writing...
        $this->fileHandle = fopen($saveTo, 'w+');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FILE, $this->fileHandle);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, "MY+USER+AGENT"); //Make this valid if possible
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); # optional
        curl_setopt($ch, CURLOPT_TIMEOUT, 3600); # optional: -1 = unlimited, 3600 = 1 hour
        curl_setopt($ch, CURLOPT_VERBOSE, false); # Set to true to see all the innards

        # Only if you need to bypass SSL certificate validation
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        # Assign a callback function to the CURL Write-Function
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($cp, $data) {
            return fwrite($this->fileHandle, $data);
        });

        # Exceute the download - note we DO NOT put the result into a variable!
        curl_exec($ch);

        # Close CURL
        curl_close($ch);

        # Close the file pointer
        fclose($this->fileHandle);
    }

    public function test(string $url){
        $limit = [100,120,140,160,180,200,220,240,260,280,300];
        $times = [];
        $memory = [];

        for ($i=0;$i<sizeof($limit);$i++){
            $this->conn->executeStatement("DELETE FROM employer_line");
            $this->start();
            $this->readToDatabase($url,",",$limit[$i]);
            $times[$i] = $this->stop();
            $memory[$i] = $this->formatBytes(memory_get_peak_usage());
            echo sprintf("%d/%d\n",$i+1,sizeof($limit));
        }

        dd($limit,$times,$memory);

    }

    public function readToDatabase(string $url, string $separator = ",", int $linesLimit = 200) {
        $this->start();
        $handle = fopen($url, "r");

        $counter = 0;
        $data = [];
        $c = 0;
        $keys = explode($separator, fgets($handle));
        $query = (new BulkInsert($this->conn));
        while (!feof($handle)) {
            if ($counter++ >= $linesLimit) {
                $rows = $query->execute('employer_line', $data);
                $counter = 0;
                $data = [];
                $c++;
            }

            $string = fgets($handle);
            $temp = explode($separator, $string);
            $data[] = [
                "id" => $temp[0],
                "medical_facility_id" => $temp[1],
                "code" => $temp[2],
                "facility_name" => $temp[3],
                "facility_type" => $temp[4],
                "address" => $temp[7]." ".$temp[8].", ".$temp[6]." ".$temp[5],
                "phone_number" => $temp[14],
                "email"=>$temp[16],
                "web"=>$temp[17],
                "ico"=>$temp[18],
                "field_of_care"=>$temp[27],
                "form_of_care"=>$temp[28],
                "type_of_care"=>$temp[29],
                "representative"=>$temp[30]
            ];
        }

        fclose($handle);
    }

    private function readTheFile(string $url) {

    }

    private function formatBytes($bytes, $precision = 2) {
        $units = array("b", "kb", "mb", "gb", "tb");

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . " " . $units[$pow];
    }

}