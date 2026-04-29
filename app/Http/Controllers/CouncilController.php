<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouncilRequest;
use App\Http\Resources\CouncilResource;
use App\Models\User;

class CouncilController extends Controller
{
    public function index()
    {
        $councils = User::with(['province', 'regency', 'district', 'village'])->where('role', 'council')->latest()->get();

        return CouncilResource::collection($councils);
    }

    public function store(CouncilRequest $request)
    {
        $data = $request->validated();
        $data['role'] = 'council';
        $data['type'] = 'admin';

        if ($request->hasFile('photo')) {
            $data['photo'] = User::uploadPhoto($request->file('photo'), $data['nik']);
        }

        if ($request->hasFile('ktp_photo')) {
            $data['ktp_photo'] = User::uploadKtpPhoto($request->file('ktp_photo'), $data['nik']);
        }

        $council = User::create($data);

        $council->load(['province', 'regency', 'district', 'village']);

        return new CouncilResource($council);
    }

    public function show(User $council)
    {
        if ($council->role !== 'council') {
            abort(404);
        }

        $council->load(['province', 'regency', 'district', 'village']);

        return new CouncilResource($council);
    }

    public function update(CouncilRequest $request, User $council)
    {
        if ($council->role !== 'council') {
            abort(404);
        }

        $council->update($request->validated());

        if ($request->hasFile('photo')) {
            $council->deletePhoto();
            $council->photo = User::uploadPhoto($request->file('photo'), $council->nik);
            $council->save();
        }

        if ($request->hasFile('ktp_photo')) {
            $council->deleteKtpPhoto();
            $council->ktp_photo = User::uploadKtpPhoto($request->file('ktp_photo'), $council->nik);
            $council->save();
        }

        $council->load(['province', 'regency', 'district', 'village']);

        return new CouncilResource($council);
    }

    public function destroy(User $council)
    {
        if ($council->role !== 'council') {
            abort(404);
        }

        $council->delete();

        return response()->json(['message' => 'Council deleted successfully']);
    }
}
