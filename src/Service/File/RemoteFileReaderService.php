<?php

namespace App\Service\File;

class RemoteFileReaderService {

    private $fileHandle;

    public function readToFile(string $url, string $saveTo){
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
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($cp, $data){
            return fwrite($this->fileHandle, $data);
        });

        # Exceute the download - note we DO NOT put the result into a variable!
        curl_exec($ch);

        # Close CURL
        curl_close($ch);

        # Close the file pointer
        fclose($this->fileHandle);
    }

}