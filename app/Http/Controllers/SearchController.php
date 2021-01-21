<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    const COLUMNS = ['id', 'name', 'external_id', 'description'];

    public function index(Request $request)
    {
        if (!$request->exists('query')) {
            return redirect('/');
        }

        $searchQuery = e($request->get('query'));

        $queryLike = "%$searchQuery%";
        $query = DB::table('techniques')
                ->select(self::COLUMNS)
                    ->where('name', 'LIKE', $queryLike)
                    ->orWhere('external_id', 'LIKE', $queryLike)
                    ->orWhere('description', 'LIKE', $queryLike);

        return view('search', ['query' => $searchQuery, 'techniques' => $query->get()]);
    }
}
