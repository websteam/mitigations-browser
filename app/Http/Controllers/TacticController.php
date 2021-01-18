<?php

namespace App\Http\Controllers;

use App\Models\Tactic;
use App\Models\Technique;
use App\Repository\Eloquent\TacticRepository;
use App\Repository\TacticRepositoryInterface;
use App\Repository\TechniqueRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class TacticController extends Controller
{
    protected TacticRepositoryInterface $repository;

    public function __construct(TacticRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $tactics = Tactic::all();

        return view(
            'tactics.index',
            compact('tactics')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param string $external_id
     * @return Application|Factory|View|Response
     */
    public function show(string $external_id, TechniqueRepositoryInterface $techniqueRepository)
    {
        $tactic = $this->repository->findByExternalId($external_id);

        $techniquesCount = $techniqueRepository->allTechniques()->count();
        $subtechniquesCount = $techniqueRepository->allSubtechniques()->count();

        return view(
            'tactics.show',
            compact('tactic', 'techniquesCount', 'subtechniquesCount')
        );
    }
}
