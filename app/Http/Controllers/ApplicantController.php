<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\Document;
use App\Models\ScholarshipProgram; 
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate the form 
        $validatedData = $request->validate([
            'first_name'              => 'required|string|max:255',
            'last_name'               => 'required|string|max:255',
            'middle_name'             => 'nullable|string|max:255',
            'birthdate'               => 'required|date',
            'place_of_birth'          => 'required|string|max:255',
            'sex'                     => 'required|string',
            'citizenship'             => 'required|string|max:255',
            'email'                   => 'required|email|unique:applicants,email', 
            'contact_number'          => 'required|string',
            'school'                  => 'required|string|max:255',
            'course'                  => 'required|string|max:255', 
            'school_id'               => 'required|string|max:255',
            'school_sector'           => 'required|string|max:255',
            'school_address'          => 'required|string|max:255',
            'year_level'              => 'required|string|max:255', 
            'gpa'                     => 'required|numeric',        
            'address_street_barangay' => 'required|string|max:255',
            'address_city'            => 'required|string|max:255',
            'address_province'        => 'required|string|max:255',
            'address_zip'             => 'nullable|string|max:20',
            // Family Additions
            'father_name'             => 'nullable|string|max:255',
            'father_occupation'       => 'nullable|string|max:255',
            'mother_name'             => 'nullable|string|max:255',
            'mother_occupation'       => 'nullable|string|max:255',
            'no_siblings'             => 'required|integer|min:0',
            'total_parent_income'     => 'required|numeric',
            // Documents
            'cor_document'            => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', 
            'indigency_document'      => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $fullAddress = $validatedData['address_street_barangay'] . ', ' . $validatedData['address_city'] . ', ' . $validatedData['address_province'];
        if (!empty($validatedData['address_zip'])) { $fullAddress .= ' ' . $validatedData['address_zip']; }

        // 2. Save the Applicant Record
        $applicant = Applicant::create([
            'user_id'        => Auth::id(), 
            'first_name'     => $validatedData['first_name'],
            'last_name'      => $validatedData['last_name'],
            'middle_name'    => $validatedData['middle_name'] ?? null,
            'birthdate'      => $validatedData['birthdate'],
            'place_of_birth' => $validatedData['place_of_birth'],
            'sex'            => $validatedData['sex'],
            'citizenship'    => $validatedData['citizenship'],
            'email'          => $validatedData['email'],
            'contact_number' => $validatedData['contact_number'],
            'school'         => $validatedData['school'],
            'course'         => $validatedData['course'], 
            'school_id'      => $validatedData['school_id'],
            'school_sector'  => $validatedData['school_sector'],
            'school_address' => $validatedData['school_address'],
            'year_level'     => $validatedData['year_level'], 
            'gpa'            => $validatedData['gpa'],    
            'address'        => $fullAddress, 
        ]);

        // 3. Save the Family Record (Now includes the parents!)
        Family::create([
            'applicant_id'        => $applicant->id,
            'father_name'         => $validatedData['father_name'] ?? null,
            'father_occupation'   => $validatedData['father_occupation'] ?? null,
            'mother_name'         => $validatedData['mother_name'] ?? null,
            'mother_occupation'   => $validatedData['mother_occupation'] ?? null,
            'no_siblings'         => $validatedData['no_siblings'],
            'total_parent_income' => $validatedData['total_parent_income'],
        ]);

        // 4. Save Documents
        $this->storeDocument($request->file('cor_document'), 'cor', $applicant->id);
        $this->storeDocument($request->file('indigency_document'), 'indigency', $applicant->id);

        $program = ScholarshipProgram::firstOrCreate(
            ['name' => 'UniFAST-TDP'],
            ['description' => 'Default Tulong Dunong Program', 'grant_amount' => 0.00, 'slots' => 100, 'deadline' => '2026-12-31']
        );

        \App\Models\Application::create([
            'applicant_id'           => $applicant->id,
            'scholarship_program_id' => $program->id, 
            'status'                 => 'pending',
        ]);

        return back()->with('success', 'Application submitted successfully! Your documents are now pending review.');
    }

    private function storeDocument($file, $type, $applicantId)
    {
        if ($file) {
            $path = $file->store('documents', 'public');
            Document::create(['applicant_id' => $applicantId, 'document_type' => $type, 'file_path' => $path]);
        }
    }
}