<?php

namespace App\Http\Controllers;

use App\Models\Tactic;
use App\Models\Technique;
use App\Repository\TechniqueRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class TacticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index(TechniqueRepositoryInterface $techniqueRepository)
    {
        $tactics = Tactic::all();
        $techniquesCount = Technique::where([
            'parent_id' => null
        ])->count();


        return view('tactics.index', compact('tactics', 'techniquesCount'));
    }

    /**
     * Display the specified resource.
     *
     * @param Tactic $tactic
     * @return Application|Factory|View|Response
     */
    public function show(Tactic $tactic)
    {
        return view('tactics.show', compact('tactic'));
    }
}
