<?php

namespace App\Http\Controllers;

use App\Models\Technique;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class TechniqueController extends Controller
{
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
     * @param Technique $technique
     * @return Application|Factory|View|Response
     */
    public function show(Technique $technique)
    {
        return view('techniques.show', compact('technique'));
    }
}
