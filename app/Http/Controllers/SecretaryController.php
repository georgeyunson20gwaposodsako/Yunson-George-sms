<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Document;
use App\Models\Family;
use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    public function dashboard()
    {
        return view('secretary.dashboard');
    }

    public function index()
    {
        $applicants = Applicant::with('applications')->latest()->get();
        return view('secretary.applicants.index', compact('applicants'));
    }

    public function create()
    {
        return view('secretary.applicants.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'income' => 'required|numeric|min:0',
        ]);

        $applicant = Applicant::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'school' => $data['school'],
            'email' => 'noemail_' . time() . rand(10, 99) . '@local.test',
            'contact_number' => 'N/A',
            'address' => 'N/A',
            'birthdate' => now()->toDateString(),
            'course' => 'N/A',
            'gpa' => 0,
        ]);

        Family::updateOrCreate(
            ['applicant_id' => $applicant->id],
            ['total_parent_income' => $data['income']]
        );

        return redirect()->route('secretary.applicants')->with('success', 'Applicant saved successfully.');
    }

    public function edit(int $id)
    {
        $applicant = Applicant::with('family')->findOrFail($id);
        return view('secretary.applicants.edit', compact('applicant'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'income' => 'required|numeric|min:0',
        ]);

        $applicant = Applicant::findOrFail($id);
        $applicant->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'school' => $data['school'],
        ]);

        Family::updateOrCreate(
            ['applicant_id' => $applicant->id],
            ['total_parent_income' => $data['income']]
        );

        return redirect()->route('secretary.applicants')->with('success', 'Applicant updated successfully.');
    }

    public function destroy(int $id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->delete();

        return redirect()->route('secretary.applicants')->with('success', 'Applicant deleted successfully.');
    }

    public function showUpload(int $id)
    {
        $applicant = Applicant::with('documents')->findOrFail($id);
        return view('secretary.applicants.upload', compact('applicant'));
    }

    public function upload(Request $request, int $id)
    {
        $request->validate([
            'cor' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'indigency' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if (!$request->hasFile('cor') && !$request->hasFile('indigency')) {
            return back()->withErrors(['cor' => 'Please upload at least one document.'])->withInput();
        }

        $applicant = Applicant::findOrFail($id);

        if ($request->hasFile('cor')) {
            $corPath = $request->file('cor')->store('documents', 'public');
            Document::updateOrCreate(
                ['applicant_id' => $applicant->id, 'document_type' => 'cor'],
                ['file_path' => $corPath]
            );
        }

        if ($request->hasFile('indigency')) {
            $indigencyPath = $request->file('indigency')->store('documents', 'public');
            Document::updateOrCreate(
                ['applicant_id' => $applicant->id, 'document_type' => 'indigency'],
                ['file_path' => $indigencyPath]
            );
        }

        return redirect()->route('secretary.applicants')->with('success', 'Documents uploaded successfully.');
    }
}
