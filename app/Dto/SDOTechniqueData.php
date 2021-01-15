<?php

namespace App\Dto;

class SDOTechniqueData extends SDOAbstract
{
    use SDOHasExternalReferences;

    protected string $type = 'attack-pattern';
}
