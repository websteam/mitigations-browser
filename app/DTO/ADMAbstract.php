<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class ADMAbstract
 * Base abstract class for the ATT&CK data model
 *
 * @see https://github.com/mitre/cti/blob/master/USAGE.md#the-attck-data-model
 * @package App\DTO
 */
abstract class ADMAbstract extends DataTransferObject
{
    const TYPE_TACTIC = 'x-mitre-tactic';

    const TYPE_TECHNIQUE = 'attack-pattern';

    const TYPE_RELATIONSHIP = 'relationship';

    public string $type = self::TYPE_TECHNIQUE;

    public string $id;

    public ?string $name;

    public ?string $x_mitre_shortname;

    public ?bool $x_mitre_is_subtechnique;

    public ?string $description;

    public ?string $relationship_type;

    public ?string $source_ref;

    public ?string $target_ref;

    public \DateTimeInterface $created;

    public \DateTimeInterface $modified;

    abstract public static function fromArray(array $data): self;

    abstract public static function matches(array $data): bool;
}
