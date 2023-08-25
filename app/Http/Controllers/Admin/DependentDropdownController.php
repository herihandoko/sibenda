<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DependentDropdownController extends Controller
{
    public function provinces()
    {
        return \Indonesia::allProvinces();
    }
    
    public function getCities() {
        return \Indonesia::allCities();
    }
    
    public function getDistricts() {
        return \Indonesia::allDistricts();
    }
    
    public function getVillages() {
        return \Indonesia::allVillages();
    }

    public function cities(Request $request)
    {
        return \Indonesia::findProvince($request->id, ['cities'])->cities->pluck('name', 'id');
    }

    public function districts(Request $request)
    {
        return \Indonesia::findCity($request->id, ['districts'])->districts->pluck('name', 'id');
    }

    public function villages(Request $request)
    {
        return \Indonesia::findDistrict($request->id, ['villages'])->villages->pluck('name', 'id');
    }
}