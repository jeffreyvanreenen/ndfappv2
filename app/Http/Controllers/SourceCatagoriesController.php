<?php

namespace App\Http\Controllers;

use App\Models\SourceCatagory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SourceCatagoriesController extends Controller
{
    public function index()
    {
        $sourcecategories = SourceCatagory::orderBy('name')->with('RSSfeeds')->get();
        return Inertia::render('SourceCatagories/Index')->with('sourcecategories', $sourcecategories);
    }

    public function create()
    {
        return Inertia::render('SourceCatagories/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_url' => 'required|active_url',
            'name' => 'required|unique:source_catagories',
            'description' => 'required',
        ]);

        $source = new SourceCatagory;
        $source->image_url = $request->image_url;
        $source->name = $request->name;
        $source->description = $request->description;
        $source->save();

        return redirect()->route('sources.index')->with('message', 'Succesvol toegevoegd!');

    }

    public function show(SourceCatagory $sourceCatagory)
    {
        //
    }

    public function edit(SourceCatagory $sourceCatagory)
    {
        //
    }

    public function update(Request $request, SourceCatagory $sourceCatagory)
    {
        //
    }

    public function destroy(SourceCatagory $sourceCatagory)
    {
        //
    }
}
