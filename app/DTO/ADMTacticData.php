<?php

namespace App\DTO;

use DateTime;

class ADMTacticData extends ADMAbstract
{
    use ADMHasExternalReferences;

    public string $type = ADMAbstract::TYPE_TACTIC;

    public ?string $x_mitre_shortname;

    /**
     * @var ADMTechniqueData[]|ADMDataCollection|null
     */
    public ?ADMDataCollection $techniques;

    public static function fromArray(array $data): self
    {
        return new self([
            'id' => $data['id'],
            'name' => $data['name'],
            'x_mitre_shortname' => $data['x_mitre_shortname'],
            'description' => $data['description'],
            'external_references' => self::parseReferences($data['external_references']),
            'modified' => new DateTime($data['modified']),
            'created' => new DateTime($data['created'])
        ]);
    }

    public static function matches(array $data): bool
    {
        return array_key_exists('x_mitre_shortname', $data)
            && $data['type'] == ADMAbstract::TYPE_TACTIC;
    }
}
