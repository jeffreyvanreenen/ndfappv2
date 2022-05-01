<?php

namespace App\Http\Controllers;

use App\Models\RssItem;
use App\Models\SearchString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SearchStringsController extends Controller
{
    public function index()
    {
        $searchstrings = SearchString::all();

        return Inertia::render('Searchstring/Index')->with('searchstrings', $searchstrings);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:search_strings',
            'kleur' => 'required',
            'zoekopdracht' => 'required',
        ]);

        $zoekopdracht = new SearchString;
        $zoekopdracht->name = $request->name;
        $zoekopdracht->color = $request->kleur;
        $zoekopdracht->searchstring = $request->zoekopdracht;
        $zoekopdracht->save();

        return redirect()->back()->with('message', 'Zoekopdracht succesvol aangemaakt!');;
    }

    public function show(SearchString $searchString)
    {
        //
    }

    public function edit($searchstring)
    {
        $zoekopdracht = SearchString::find($searchstring);
        $zoekresultaten = RssItem::search($zoekopdracht->searchstring)->get();

        return Inertia::render('Searchstring/Edit')->with('zoekopdracht', $zoekopdracht)->with('zoekresultaten', $zoekresultaten);
    }

    public function update(Request $request, SearchString $searchString)
    {
        $validated = $request->validate([
            'name' => 'required',
            'kleur' => 'required',
            'zoekopdracht' => 'required',
        ]);



        $searchString->name = $request->name;
        $searchString->color = $request->kleur;
        $searchString->searchstring = $request->zoekopdracht;
        $searchString->save();

        return redirect()->back()->with('message', 'Zoekopdracht succesvol aangepast!');;
    }

    public function destroy(SearchString $searchString)
    {
        //
    }
}
