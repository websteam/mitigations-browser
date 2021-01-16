<?php

namespace App\DTO;

trait ADMHasKillChainPhases
{
    /** @var ADMKillChainPhase[]|array $external_references */
    public ?array $kill_chain_phases;

    /**
     * @param array[] $kill_chain_phases
     * @return ADMKillChainPhase[]|array
     */
    public static function parsePhases(array $kill_chain_phases): array
    {
        return array_map(function ($kill_chain_phase) {
            return new ADMKillChainPhase($kill_chain_phase);
        }, $kill_chain_phases);
    }

    /**
     * Gets a phase_name parameter of first object
     * from kill_chain_phases which basically would
     * be Tactic x_mitre_short_name
     *
     * @return string|null
     */
    public function getPhaseName(): ?string
    {
        if (isset($this->kill_chain_phases[0])) {
            return $this->kill_chain_phases[0]->phase_name ?? null;
        }

        return null;
    }
}
