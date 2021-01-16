<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ADMKillChainPhase extends DataTransferObject
{
    public ?string $kill_chain_name = 'mitre-attack';

    public ?string $phase_name;
}
