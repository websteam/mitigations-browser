<?php

namespace App\Dto;

use Spatie\DataTransferObject\DataTransferObject;

abstract class SDOAbstract extends DataTransferObject
{
    public string $id;

    public string $name;

    public string $description;

    public \DateTimeInterface $created;

    public \DateTimeInterface $modified;

    protected string $type = 'attack-pattern';

    public function getType(): string
    {
        return $this->type;
    }
}
