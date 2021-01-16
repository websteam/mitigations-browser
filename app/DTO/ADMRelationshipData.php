<?php

namespace App\DTO;

use DateTime;

class ADMRelationshipData extends ADMAbstract
{
    const TYPE = 'relationship';

    public string $relationship_type;

    public string $source_ref;

    public string $target_ref;

    public static function fromArray(array $data): self
    {
        return new self([
            'id' => $data['id'],
            'source_ref' => $data['source_ref'],
            'target_ref' => $data['target_ref'],
            'relationship_type' => $data['relationship_type'],
            'created' => new DateTime($data['created']),
            'modified' => new DateTime($data['modified'])
        ]);
    }

    public static function matches(array $data): bool
    {
        return $data['type'] == static::TYPE
            && array_key_exists('relationship_type', $data);
    }
}
