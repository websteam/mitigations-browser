<?php

namespace App\DTO;

trait ADMHasExternalReferences
{
    /** @var ADMExternalReference[]|array $external_references */
    public array $external_references;

    /**
     * @param array[] $references
     * @return ADMExternalReference[]|array
     */
    public static function parseReferences(array $references): array
    {
        return array_map(function ($reference) {
            return new ADMExternalReference($reference);
        }, $references);
    }
}
