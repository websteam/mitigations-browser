<?php

namespace App\DTO;

use DateTime;

class ADMTechniqueData extends ADMAbstract
{
    use ADMHasExternalReferences;

    const TYPE = 'attack-pattern';

    public bool $x_mitre_is_subtechnique = false;

    public static function fromArray(array $data): self
    {
        return new self([
            'id' => $data['id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'external_references' => self::parseReferences($data['external_references']),
            'modified' => new DateTime($data['modified']),
            'created' => new DateTime($data['created'])
        ]);
    }

    public static function matches(array $data): bool
    {
        return $data['type'] == 'attack-pattern'
            && isset($data['x_mitre_is_subtechnique'])
            && $data['x_mitre_is_subtechnique'] === false;
    }
}
