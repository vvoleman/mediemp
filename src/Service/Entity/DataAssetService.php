<?php

namespace App\Service\Entity;

use App\Entity\DataAsset;
use App\Entity\DataAssetVersion;
use App\Repository\DataAssetRepository;
use App\Repository\DataAssetVersionRepository;
use App\Security\LoggerAwareTrait;
use App\Service\File\CsvService;
use App\Service\File\RemoteFileReaderService;
use App\Service\Util\TimeTrackerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use PHPUnit\Runner\Exception;
use Symfony\Contracts\Cache\CacheInterface;

class DataAssetService {

    use LoggerAwareTrait;
    use TimeTrackerTrait;

    public const FOLDER = "../var/files";

    private DataAssetRepository $assetRepository;
    private DataAssetVersionRepository $versionRepository;
    private CsvService $csv;
    private RemoteFileReaderService $readerService;
    private EntityManagerInterface $entityManager;
    private CacheInterface $cache;

    public function __construct(DataAssetRepository        $assetRepository,
                                DataAssetVersionRepository $versionRepository,
                                CsvService                 $csv,
                                RemoteFileReaderService    $readerService,
                                EntityManagerInterface     $entityManager,
                                CacheInterface             $cache
    ) {
        $this->assetRepository = $assetRepository;
        $this->versionRepository = $versionRepository;
        $this->csv = $csv;
        $this->readerService = $readerService;
        $this->entityManager = $entityManager;
        $this->cache = $cache;
    }

    /**
     * @throws NoResultException
     */
    public function searchFor(string $assetName, string $search): array {
        $asset = $this->assetRepository->findOneBy(["name" => $assetName]);
        if (!$asset) {
            $this->getLogger()->error("Couldn't found DataAsset!", [
                "assetName" => $assetName,
                "result" => $asset
            ]);
            throw new NoResultException();
        }

        $version = $this->versionRepository->getLastVersion($asset->getId());
        $this->start();
        if (!$version) {
            $version = $this->addVersion($asset);
        }

        switch ($asset->getType()) {
            case "csv":
                return $this->cache->get("data_asset_" . $assetName."_".$search, function () use ($version,$search) {
                    return $this->csv->searchFile(self::FOLDER . $version->getFileName(), [
                        "NazevZarizeni" => $search
                    ]);
                });
            default:
                throw new Exception(sprintf("Unknown type '%s'", $version->getType()));
        }

    }

    public
    function addVersion(DataAsset $asset) {
        $this->start();
        $date = new \DateTime();
        $name = sprintf("/data_assets/assets/%s-%s_%d.csv", strtolower($asset->getName()), $date->format("Y-m-d"), uniqid());
        $this->readerService->readToFile($asset->getSourceLink(), self::FOLDER . $name);
        $v = new DataAssetVersion();
        $v->setFileName($name);
        $v->setCreatedAt();
        $v->setDataAsset($asset);
        $v->setProcessTime($this->stop());
        $this->entityManager->persist($v);
        $this->entityManager->flush();

        return $v;
    }

}