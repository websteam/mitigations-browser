<?php

namespace App\Dto;

class SDOTacticData extends SDOAbstract
{
    use SDOHasExternalReferences;

    public string $slug;

    public string $description;

    protected string $type = 'x-mitre-tactic';
}
