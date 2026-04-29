<?php

namespace App\Http\Controllers;

use App\Http\Requests\KtaRequest;
use App\Http\Resources\KtaResource;
use App\Models\Kta;

class KtaController extends Controller
{
    public function index()
    {
        $ktas = Kta::with(['province', 'regency', 'district', 'village'])->latest()->get();

        return KtaResource::collection($ktas);
    }

    public function store(KtaRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = Kta::uploadPhoto($request->file('photo'), $data['nik']);
        }

        $kta = Kta::create($data);

        $kta->load(['province', 'regency', 'district', 'village']);

        return new KtaResource($kta);
    }

    public function show(Kta $kta)
    {
        $kta->load(['province', 'regency', 'district', 'village']);

        return new KtaResource($kta);
    }

    public function update(KtaRequest $request, Kta $kta)
    {
        $kta->update($request->validated());

        if ($request->hasFile('photo')) {
            $kta->deletePhoto();
            $kta->photo = Kta::uploadPhoto($request->file('photo'), $kta->nik);
            $kta->save();
        }

        $kta->load(['province', 'regency', 'district', 'village']);

        return new KtaResource($kta);
    }

    public function destroy(Kta $kta)
    {
        $kta->deletePhoto();
        $kta->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
