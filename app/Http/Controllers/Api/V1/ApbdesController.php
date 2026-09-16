<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Apbdes;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApbdesResource;

class ApbdesController extends Controller
{
    /**
     * index
     *
     * @return ApbdesResource
     */
    public function index()
    {
        $apbdes = Apbdes::query()
            ->when(request()->tahun, function ($query) {
                $query->where(
                    'tahun',
                    request()->tahun
                );
            })
            ->where('status', 'published')
            ->latest('tahun')
            ->paginate(10);

        $apbdes->appends([
            'tahun' => request()->tahun,
        ]);

        return ApbdesResource::collection($apbdes)
            ->additional([
                'success' => true,
                'message' => 'List Data APBDes',
            ]);
    }
}