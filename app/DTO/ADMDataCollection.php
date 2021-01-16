<?php

namespace App\DTO;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObjectCollection;

class ADMDataCollection extends Collection
{
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

//    /**
//     * @param string $field
//     * @param mixed $value
//     * @return ADMDataCollection
//     */
//    public function findBy(string $field, $value): ADMDataCollection
//    {
//        return new self(array_filter(
//            $this->items,
//            function ($item) use ($field, &$value) {
//                if (!isset($item->{$field})) return false;
//
//                return $item->{$field} == $value;
//            }
//        ));
//    }
//
//    public function findFirstBy(string $field, $value): ?ADMAbstract
//    {
//        $search = $this->findBy($field, $value);
//
//        if (count($search) == 0) return null;
//
//        return $search[0];
//    }
//
//    public function findOneBy(string $field, $value): ?ADMAbstract
//    {
//        $search = $this->findBy($field, $value);
//
//        if (count($search) == 0) return null;
//
//        return $search[count($search) - 1];
//    }
//
//    /**
//     * @param array $conditions
//     * @return ADMDataCollection
//     */
//    public function find(array $conditions)
//    {
//        $isValid = function($obj, $propKey, $propVal) {
//            if (is_int($propKey)) {
//                if (!property_exists($obj, $propVal) || empty($obj->{$propVal})) {
//                    return false;
//                }
//            } else {
//                if (!property_exists($obj, $propKey)) {
//                    return false;
//                }
//                if (is_callable($propVal)) {
//                    return call_user_func($propVal, $obj->{$propKey});
//                }
//                if (strtolower($obj->{$propKey}) != strtolower($propVal)) {
//                    return false;
//                }
//            }
//            return true;
//        };
//
//        return new self(array_filter(
//            $this->items,
//            function ($item) use ($conditions, $isValid) {
//                foreach ($conditions as $property => $value) {
//                    if (is_array($value)) {
//                        $prop = array_shift($value);
//                        if (!property_exists($item, $prop)) {
//                            return false;
//                        }
//                        reset($value);
//                        $key = key($value);
//                        if (!$isValid($item->{$prop}, $key, $value[$key])) {
//                            return false;
//                        }
//                    } else {
//                        if (!$isValid($item, $property, $value)) {
//                            return false;
//                        }
//                    }
//                }
//                return true;
//            }
//        ));
//    }
//
//    public function findFirst(array $conditions): ?ADMAbstract
//    {
//        $search = $this->find($conditions);
//
//        if (count($search) == 0) return null;
//
//        return $search[0];
//    }
//
//    public function findOne(array $conditions): ?ADMAbstract
//    {
//        $search = $this->find($conditions);
//
//        if (count($search) == 0) return null;
//
//        return $search[count($search) - 1];
//    }
}
