<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Http\Resources\DivisionCollection;
use App\Http\Resources\DivisionResource;
use App\Models\Division;
use App\Models\SubDivision;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivisionsController extends Controller
{
    public function store(DivisionRequest $request)
    {
        DB::beginTransaction();
        try {
            $division = new Division;
            $division->name = $request->name;
            $division->level = $request->level;
            $division->number_collaborators = $request->number_collaborators;
            $division->ambassador_id = $request->ambassador_id;
            $division->superior_division_id = $request->superior_division_id;
            $division->save();

            if (isset($validated['sub_divisions'])) {
                for ($i = 0; $i < count($validated['sub_divisions']); $i++) {
                    $subDivision = new SubDivision;
                    $subDivision->name = $validated['sub_divisions'][$i];
                    $subDivision->division_id = $division->id;
                    $subDivision->save();
                }
            }

            DB::commit();

            return new DivisionResource($division);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(null, 501);
        }
    }

    public function update(UpdateDivisionRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $division = Division::find($id);
            $division->name = $request->name;
            $division->level = $request->level;
            $division->number_collaborators = $request->number_collaborators;
            $division->ambassador_id = $request->ambassador_id;
            $division->superior_division_id = $request->superior_division_id;
            $division->save();

            if (isset($validated['sub_divisions'])) {
                for ($i = 0; $i < count($validated['sub_divisions']); $i++) {
                    $subDivision = new SubDivision;
                    $subDivision->name = $validated['sub_divisions'][$i];
                    $subDivision->division_id = $division->id;
                    $subDivision->save();
                }
            }

            DB::commit();

            return new DivisionResource($division);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(null, 501);
        }
    }

    public function delete($id)
    {
        $division = Division::find($id);
        $division->delete();

        return response()->json(null);
    }

    public function getDivision($id)
    {
        $division = Division::with('ambassador', 'superDivision', 'subDivisions')->find($id);

        return new DivisionResource($division);
    }

    public function getDivisions() {
        $divisions = Division::query()->get();

        return new DivisionCollection($divisions);
    }
}
