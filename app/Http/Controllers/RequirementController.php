<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    public function index()
    {
        return response()->json(Requirement::with('scholarshipProgram')->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'scholarship_program_id' => 'required|exists:scholarship_programs,id',
            'document_name'          => 'required|string',
            'is_required'            => 'boolean',
        ]);
        $requirement = Requirement::create($request->all());
        return response()->json($requirement, 201);
    }

    public function show($id)
    {
        $requirement = Requirement::with('scholarshipProgram')->findOrFail($id);
        return response()->json($requirement, 200);
    }

    public function update(Request $request, $id)
    {
        $requirement = Requirement::findOrFail($id);
        $requirement->update($request->all());
        return response()->json($requirement, 200);
    }

    public function destroy($id)
    {
        Requirement::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
