<?php

namespace App\DTO;

use DateTime;

class ADMSubtechniqueData extends ADMAbstract
{
    use ADMHasExternalReferences;

    public string $type = ADMAbstract::TYPE_TECHNIQUE;

    public ?bool $x_mitre_is_subtechnique = true;

    public static function fromArray(array $data): self
    {
        return new self([
            'id' => $data['id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'x_mitre_is_subtechnique' => $data['x_mitre_is_subtechnique'],
            'external_references' => self::parseReferences($data['external_references']),
            'modified' => new DateTime($data['modified']),
            'created' => new DateTime($data['created'])
        ]);
    }

    public static function matches(array $data): bool
    {
        return $data['type'] == ADMAbstract::TYPE_TECHNIQUE
            && isset($data['x_mitre_is_subtechnique'])
            && $data['x_mitre_is_subtechnique'] === true;
    }
}
