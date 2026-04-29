<?php

namespace App\Http\Controllers;

use App\Http\Requests\MassaRequest;
use App\Http\Resources\MassaResource;
use App\Models\Massa;

class MassaController extends Controller
{
    public function index()
    {
        $massas = Massa::with(['province', 'regency', 'district', 'village'])->latest()->get();

        return MassaResource::collection($massas);
    }

    public function store(MassaRequest $request)
    {
        $massa = Massa::create($request->except('photo'));

        if ($request->hasFile('photo')) {
            $massa->photo = Massa::uploadPhoto($request->file('photo'), $massa->nik);
            $massa->save();
        }

        $massa->load(['province', 'regency', 'district', 'village']);

        return new MassaResource($massa);
    }

    public function show(Massa $massa)
    {
        $massa->load(['province', 'regency', 'district', 'village']);

        return new MassaResource($massa);
    }

    public function update(MassaRequest $request, Massa $massa)
    {
        $massa->update($request->except('photo'));

        if ($request->hasFile('photo')) {
            $massa->deletePhoto();
            $massa->photo = Massa::uploadPhoto($request->file('photo'), $massa->nik);
            $massa->save();
        }

        $massa->load(['province', 'regency', 'district', 'village']);

        return new MassaResource($massa);
    }

    public function destroy(Massa $massa)
    {
        $massa->deletePhoto();
        $massa->delete();

        return response()->json(['message' => 'Massa deleted successfully']);
    }
}
