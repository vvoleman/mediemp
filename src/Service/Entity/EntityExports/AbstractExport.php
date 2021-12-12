<?php

namespace App\Service\Entity\EntityExports;

use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractExport {

    public function __construct(protected TranslatorInterface $translator) {
    }

    public abstract function exportMany(array $data): array;

    public abstract function getKeys(): array;

}