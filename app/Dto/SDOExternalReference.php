<?php


namespace App\Dto;


use Spatie\DataTransferObject\DataTransferObject;

class SDOExternalReference extends DataTransferObject
{
    public ?string $external_id;

    public string $url;

    public string $source_name;

    public ?string $description;
}
