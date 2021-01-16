<?php


namespace App\DTO;


use Spatie\DataTransferObject\DataTransferObject;

class ADMExternalReference extends DataTransferObject
{
    public ?string $external_id;

    public ?string $url;

    public ?string $source_name;

    public ?string $description;
}
