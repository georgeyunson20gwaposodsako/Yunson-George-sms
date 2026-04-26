<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        return response()->json(Application::with(['applicant', 'scholarshipProgram'])->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'applicant_id'           => 'required|exists:applicants,id',
            'scholarship_program_id' => 'required|exists:scholarship_programs,id',
        ]);
        $application = Application::create($request->all());
        return response()->json($application, 201);
    }

    public function show($id)
    {
        $application = Application::with(['applicant', 'scholarshipProgram'])->findOrFail($id);
        return response()->json($application, 200);
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $request->validate([
            'status'  => 'sometimes|in:pending,approved,rejected',
            'remarks' => 'sometimes|nullable|string',
        ]);
        $application->update($request->all());
        return response()->json($application, 200);
    }

    public function destroy($id)
    {
        Application::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }

    public function byStatus($status)
    {
        $status = strtolower($status);
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return response()->json(['message' => 'Invalid status'], 422);
        }
        return response()->json(Application::with(['applicant', 'scholarshipProgram'])->where('status', $status)->get(), 200);
    }

    public function byApplicant($applicantId)
    {
        return response()->json(Application::with(['scholarshipProgram'])->where('applicant_id', $applicantId)->get(), 200);
    }

    public function byProgram($scholarshipProgramId)
    {
        return response()->json(Application::with(['applicant'])->where('scholarship_program_id', $scholarshipProgramId)->get(), 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);
        $application = Application::findOrFail($id);
        $application->update(['status' => $request->status]);
        return response()->json($application, 200);
    }
}