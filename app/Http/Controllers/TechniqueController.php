<?php

namespace App\Http\Controllers;

use App\Models\Technique;
use App\Repository\TechniqueRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class TechniqueController extends Controller
{
    protected TechniqueRepositoryInterface $repository;

    public function __construct(TechniqueRepositoryInterface $repository)
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
        $techniques = Technique::all();

        return view('techniques.index', compact('techniques'));
    }

    /**
     * Display the specified resource.
     *
     * @param string $external_id
     * @return Application|Factory|View|Response
     */
    public function show(string $external_id)
    {
        $technique = $this->repository->findByExternalId($external_id);

        if (!$technique) {
            throw new EntityNotFoundException();
        }

        return view('techniques.show', compact('technique'));
    }
}
