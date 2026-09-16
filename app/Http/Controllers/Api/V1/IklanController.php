<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\IklanResource;
use App\Models\Iklan;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IklanController extends Controller
{
    /**
     * Menampilkan seluruh data iklan.
     */
    public function index(): AnonymousResourceCollection
    {
        $iklans = Iklan::query()
            ->latest()
            ->paginate(5);

        return IklanResource::collection($iklans)
            ->additional([
                'success' => true,
                'message' => 'List Data Iklan',
            ]);
    }

    /**
     * Menampilkan seluruh iklan yang aktif.
     */
    public function iklanAktif(): AnonymousResourceCollection
    {
        $iklans = Iklan::query()
            ->where('is_active', true)
            ->latest()
            ->paginate(5);

        return IklanResource::collection($iklans)
            ->additional([
                'success' => true,
                'message' => 'List Iklan Aktif',
            ]);
    }
}
