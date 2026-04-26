<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipProgram;
use Illuminate\Http\Request;

class ScholarshipProgramController extends Controller
{
    public function index()
    {
        return response()->json(ScholarshipProgram::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string',
            'description'  => 'sometimes|nullable|string',
            'grant_amount' => 'required|numeric',
            'slots'        => 'required|integer',
            'deadline'     => 'required|date',
            'status'       => 'sometimes|in:open,closed',
        ]);
        $program = ScholarshipProgram::create($request->all());
        return response()->json($program, 201);
    }

    public function show($id)
    {
        $program = ScholarshipProgram::with(['requirements', 'applications.applicant'])->findOrFail($id);
        return response()->json($program, 200);
    }

    public function update(Request $request, $id)
    {
        $program = ScholarshipProgram::findOrFail($id);
        $request->validate([
            'name'         => 'sometimes|required|string',
            'description'  => 'sometimes|nullable|string',
            'grant_amount' => 'sometimes|required|numeric',
            'slots'        => 'sometimes|required|integer',
            'deadline'     => 'sometimes|required|date',
            'status'       => 'sometimes|in:open,closed',
        ]);
        $program->update($request->all());
        return response()->json($program, 200);
    }

    public function openPrograms()
    {
        return response()->json(ScholarshipProgram::where('status', 'open')->get(), 200);
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:open,closed']);
        $program = ScholarshipProgram::findOrFail($id);
        $program->update(['status' => $request->status]);
        return response()->json($program, 200);
    }

    public function destroy($id)
    {
        ScholarshipProgram::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}