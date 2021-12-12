<?php

namespace App\Service\Entity;

use App\Entity\EmployerLine;
use App\Repository\DataAssetRepository;
use App\Security\LoggerAwareTrait;
use App\Service\File\RemoteFileReaderService;
use App\Service\Util\TimeTrackerTrait;
use Doctrine\ORM\NoResultException;
use JetBrains\PhpStorm\ArrayShape;

class EmployerLineService {

    use LoggerAwareTrait;
    use TimeTrackerTrait;

    public const ASSET_NAME = 'nrpzs';

    private DataAssetRepository $assetRepository;
    private RemoteFileReaderService $readerService;

    public function __construct(DataAssetRepository $assetRepository, RemoteFileReaderService $readerService) {
        $this->assetRepository = $assetRepository;
        $this->readerService = $readerService;
    }

    /**
     * @throws NoResultException
     */
    public
    function update() {
        $asset = $this->assetRepository->findOneBy(["name" => self::ASSET_NAME]);
        if (!$asset) {
            $this->getLogger()->error("Couldn't found DataAsset!", [
                "assetName" => self::ASSET_NAME,
                "result" => $asset
            ]);
            throw new NoResultException();
        }
        $this->start();
        $this->readerService->readToDatabase($asset->getSourceLink(), "employer_line", function (array $arr) {
            return [
                "id" => $arr[0],
                "medical_facility_id" => $arr[1],
                "code" => $arr[2],
                "facility_name" => $arr[3],
                "facility_type" => $arr[4],
                "address" => trim($arr[7] . " " . $arr[8] . ", " . $arr[6] . " " . $arr[5]),
                "phone_number" => $arr[14],
                "email" => $arr[16],
                "web" => $arr[17],
                "ico" => $arr[18],
                "field_of_care" => $arr[27],
                "form_of_care" => $arr[28],
                "type_of_care" => $arr[29],
                "representative" => $arr[30]
            ];
        });
        $this->getLogger()->info(sprintf("Employer Lines retrieved in %fs", $this->stop()));
    }

    public static function formatArrayToEmployer(EmployerLine $line, string $email) {
        return [
            "name" => $line->getFacilityName(),
            "address" => $line->getAddress(),
            "provider_type" => $line->getFieldOfCare(),
            "form_of_care" => $line->getFormOfCare(),
            //"line_id" => $line->getId(),
            "confirm_email" => $email
        ];
    }

}