<?php

namespace App\Service\File;

use App\Security\LoggerAwareTrait;
use Symfony\Component\Filesystem\Filesystem;

class CsvService {

    use LoggerAwareTrait;

    private Filesystem $filesystem;
    private CacheInterface $cache;

    public function __construct(Filesystem $filesystem) {
        $this->filesystem = $filesystem;
    }

    public function searchFile(string $path, array $search,string $delimiter = ","): array {
        $handle = fopen($path, "r");
        if ($handle) {
            $keys = explode($delimiter, str_replace("\r\n", "", fgets($handle)));

            while (($line = fgets($handle)) !== false) {
                $l = explode($delimiter, $line);
                $arr = [];
                try {
                    for ($i = 0; $i < sizeof($keys); $i++) {
                        $arr[$keys[$i]] = $l[$i];
                    }
                    $found = true;
                    foreach ($search as $key => $v) {
                        if($arr[$key] != $v){
                            $found = false;
                            break;
                        }
                    }
                    if($found){
                        fclose($handle);
                        return $arr;
                    }
                } catch (\Exception $e) {
                    $this->getLogger()->error("Invalid CSV format!", [
                        "exception" => $e,
                        "filename" => $path
                    ]);
                    throw $e;
                }
            }
            fclose($handle);
            return [];
        } else {
            $this->getLogger()->error("CSV file '%s' can't be opened!", [
                "filename" => $path,
                "cwd" => getcwd()
            ]);
            throw new \Exception(sprintf("File '%s' can't be opened!", $path));
        }
    }

}