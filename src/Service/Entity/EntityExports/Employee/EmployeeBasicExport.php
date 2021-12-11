<?php

namespace App\Service\Entity\EntityExports\Employee;

use App\Entity\Employee;
use App\Service\Entity\EntityExports\AbstractExport;

class EmployeeBasicExport extends AbstractExport {

    public const KEYS = [
        "name", "surname", "degree", "birthday", "birth_city", "citizenship", "designation_of_professional_competence",
        "diploma_number", "diploma_date", "specialized_competency", "special_professional_or_special_specialized_competencies",
        "confirmed_at"
    ];

    /**
     * @param array of Employee $data
     * @return array
     */
    public function exportMany(array $data): array {
        $result = [];
        $keys = $this->getKeys();
        $dateFormat = $this->translator->trans("global.formats.universal.date");
        /** @var Employee $d */
        foreach ($data as $d) {
            $result[] = [
                $keys["name"] => $d->getName(),
                $keys["surname"] => $d->getSurname(),
                $keys["degree"] => $d->getDegree(),
                $keys["birthday"] => $d->getBirthday()->format($dateFormat),
                $keys["birth_city"] => $d->getBirthCity(),
                $keys["citizenship"] => $d->getCitizenship(),
                $keys["designation_of_professional_competence"] => $d->getDesignationOfProfessionalCompetence(),
                $keys["diploma_number"] => $d->getDiplomaNumber(),
                $keys["diploma_date"] => $d->getDiplomaDate()->format($dateFormat),
                $keys["specialized_competency"] => $d->getSpecializedCompetency(),
                $keys["special_professional_or_special_specialized_competencies"] => $d->getSpecialProfessionalOrSpecialSpecializedCompetencies(),
                $keys["confirmed_at"] => $d->getConfirmedAt()
            ];
        }
        return $result;
    }

    public function getKeys(): array {
        $result = [];
        foreach (self::KEYS as $key) {
            $string = iconv("UTF-8", "ascii//TRANSLIT",$this->translator->trans(sprintf("employee.attributes.%s", $key)));
            $result[$key] = str_replace(" ","",ucwords(str_replace("'","",$string)));
        }
        return $result;
    }
}