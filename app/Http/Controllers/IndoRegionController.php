<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\JsonResponse;

class IndoRegionController extends Controller
{
    /**
     * Get all provinces.
     *
     * @return JsonResponse
     */
    public function provinces()
    {
        $provinces = Province::orderBy('name', 'asc')->get();

        return response()->json($provinces);
    }

    /**
     * Get regencies by province ID.
     *
     * @param  string  $provinceId
     * @return JsonResponse
     */
    public function regencies($provinceId)
    {
        $regencies = Regency::where('province_id', $provinceId)->orderBy('name', 'asc')->get()->makeVisible('province_id');

        return response()->json($regencies);
    }

    /**
     * Get districts by regency ID.
     *
     * @param  string  $regencyId
     * @return JsonResponse
     */
    public function districts($regencyId)
    {
        $districts = District::where('regency_id', $regencyId)->orderBy('name', 'asc')->get()->makeVisible('regency_id');

        return response()->json($districts);
    }

    /**
     * Get villages by district ID.
     *
     * @param  string  $districtId
     * @return JsonResponse
     */
    public function villages($districtId)
    {
        $villages = Village::where('district_id', $districtId)->orderBy('name', 'asc')->get()->makeVisible('district_id');

        return response()->json($villages);
    }

    /**
     * Get all regencies.
     *
     * @return JsonResponse
     */
    public function allRegencies()
    {
        $regencies = Regency::orderBy('name', 'asc')->get()->makeVisible('province_id');

        return response()->json($regencies);
    }

    /**
     * Get all districts.
     *
     * @return JsonResponse
     */
    public function allDistricts()
    {
        $districts = District::orderBy('name', 'asc')->get()->makeVisible('regency_id');

        return response()->json($districts);
    }

    /**
     * Get all villages.
     *
     * @return JsonResponse
     */
    public function allVillages()
    {
        $villages = Village::orderBy('name', 'asc')->get()->makeVisible('district_id');

        return response()->json($villages);
    }
}
