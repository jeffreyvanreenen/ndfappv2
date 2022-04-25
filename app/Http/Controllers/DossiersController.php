<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DossiersController extends Controller
{
    public function index()
    {
        $dossiers = Dossier::orderBy('casus_id')->get();

        return Inertia::render('Cases/Index')->with('dossiers', $dossiers);
    }

    public function create()
    {
        return Inertia::render('Cases/Create', [
            'gebruikers' => User::orderBy('name')->get()->map(function ($gebruiker) {
                return [
                    'id' => $gebruiker->id,
                    'naam' => $gebruiker->name,
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'casus_id' => 'required|unique:dossiers',
            'plaats' => 'required',
            'datum_incident' => 'required|date',
            'omschrijving' => 'required',
            'interne_betrokkenen' => 'required|array',
        ]);

        $interne_betrokkenen = json_encode($request->interne_betrokkenen, JSON_FORCE_OBJECT);

        $dossier = new Dossier;
        $dossier->casus_id = $request->casus_id;
        $dossier->plaats = $request->plaats;
        $dossier->datum_incident = $request->datum_incident;
        $dossier->omschrijving = $request->omschrijving;
        $dossier->interne_betrokkenen = $interne_betrokkenen;
        $dossier->save();

        return Redirect::route('dossier.index')->with('message','Dossier '.$request->casus_id.' succesvol aangemaakt!');;
    }

    public function show(Dossier $dossier)
    {
        //
    }

    public function edit(Dossier $dossier)
    {
        //
    }

    public function update(Request $request, Dossier $dossier)
    {
        //
    }

    public function destroy(Dossier $dossier)
    {
        //
    }
}
