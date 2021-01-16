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
    const TYPE = 'attack-pattern';

    public string $type = self::TYPE;

    public string $id;

    public ?string $name;

    public ?string $description;

    public \DateTimeInterface $created;

    public \DateTimeInterface $modified;

    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);

        $this->type = static::TYPE;
    }

    abstract public static function fromArray(array $data): self;

    abstract public static function matches(array $data): bool;
}
