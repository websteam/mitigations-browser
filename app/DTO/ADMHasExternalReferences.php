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

    /**
     * Gets an external_id parameter of first object
     * from external_references
     *
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        if (isset($this->external_references[0])) {
            return $this->external_references[0]->external_id ?? null;
        }

        return null;
    }
}
