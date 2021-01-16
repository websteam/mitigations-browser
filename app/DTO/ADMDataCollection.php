<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObjectCollection;

class ADMDataCollection extends DataTransferObjectCollection
{
    public function current(): ADMAbstract
    {
        return parent::current();
    }

    public static function create(array $data): self
    {
        $objects = [];

        foreach ($data as $dataObject) {
            $currentClass = null;
            switch($dataObject) {
                case ADMTacticData::matches($dataObject):
                    $objects[] = ADMTacticData::fromArray($dataObject);
                    break;
                case ADMTechniqueData::matches($dataObject):
                    $objects[] = ADMTechniqueData::fromArray($dataObject);
                    break;
                case ADMSubtechniqueData::matches($dataObject):
                    $objects[] = ADMSubtechniqueData::fromArray($dataObject);
                    break;
                case ADMRelationshipData::matches($dataObject):
                    $objects[] = ADMRelationshipData::fromArray($dataObject);
            }
        }

        return new self($objects);
    }
}
