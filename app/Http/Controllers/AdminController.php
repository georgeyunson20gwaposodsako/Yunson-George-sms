<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Application;
use App\Models\ScholarshipProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalApplicants' => Applicant::count(),
            'approvedCount' => Application::where('status', 'approved')->count(),
            'pendingCount' => Application::where('status', 'pending')->count(),
            'rejectedCount' => Application::where('status', 'rejected')->count(),
        ]);
    }

    public function applicants()
    {
        $applicants = Applicant::with(['family', 'applications'])
            ->latest()
            ->get();

        return view('admin.applicants.index', compact('applicants'));
    }

    public function showApplicant(int $id)
    {
        $applicant = Applicant::with(['family', 'documents', 'applications'])->findOrFail($id);
        return view('admin.applicants.show', compact('applicant'));
    }

    public function approve(int $id)
    {
        $applicant = Applicant::with(['family', 'documents'])->findOrFail($id);
        $program = ScholarshipProgram::firstOrCreate(
            ['name' => 'Default Program'],
            ['description' => 'Auto-created fallback program']
        );
        $programId = $program->id;

        $income = (float) ($applicant->family->total_parent_income ?? 0);
        $hasCor = $applicant->documents->contains(fn ($doc) => strtolower((string) $doc->document_type) === 'cor' && !empty($doc->file_path));
        $hasIndigency = $applicant->documents->contains(fn ($doc) => strtolower((string) $doc->document_type) === 'indigency' && !empty($doc->file_path));
        $documentsComplete = $hasCor && $hasIndigency;

        $status = ($income <= 400000 && $documentsComplete) ? 'approved' : 'rejected';
        $remarks = $status === 'approved'
            ? 'Qualified based on income and complete documents.'
            : 'Rejected due to income threshold or incomplete documents.';

        Application::updateOrCreate(
            ['applicant_id' => $applicant->id, 'scholarship_program_id' => $programId],
            ['status' => $status, 'remarks' => $remarks]
        );

        return redirect()->route('admin.applicants')->with('success', 'Applicant evaluated successfully.');
    }

    public function reject(int $id)
    {
        $applicant = Applicant::findOrFail($id);
        $program = ScholarshipProgram::firstOrCreate(
            ['name' => 'Default Program'],
            ['description' => 'Auto-created fallback program']
        );
        $programId = $program->id;

        Application::updateOrCreate(
            ['applicant_id' => $applicant->id, 'scholarship_program_id' => $programId],
            ['status' => 'rejected', 'remarks' => 'Rejected by admin.']
        );

        return redirect()->route('admin.applicants')->with('success', 'Applicant rejected successfully.');
    }

    public function secretaries()
    {
        $secretaries = User::where('role', 'secretary')->latest()->get();
        return view('admin.secretaries.index', compact('secretaries'));
    }

    public function storeSecretary(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'secretary',
        ]);

        return redirect()->route('admin.secretaries')->with('success', 'Secretary account created successfully.');
    }

    public function deleteSecretary(int $id)
    {
        $secretary = User::where('role', 'secretary')->findOrFail($id);
        $secretary->delete();

        return redirect()->route('admin.secretaries')->with('success', 'Secretary deleted successfully.');
    }
}
