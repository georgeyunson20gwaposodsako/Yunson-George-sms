@extends('layouts.app')

@section('title', 'Edit Applicant')

@section('content')
    <h3 class="mb-4">Edit Applicant</h3>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('secretary.applicants.update', $applicant->id) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ $applicant->first_name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ $applicant->last_name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">School</label>
                        <input type="text" name="school" class="form-control" value="{{ $applicant->school }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Income</label>
                        <input type="number" step="0.01" name="income" class="form-control" value="{{ $applicant->family->total_parent_income ?? 0 }}" required>
                    </div>
                </div>
                <button class="btn btn-primary mt-3" type="submit">Update Applicant</button>
            </form>
        </div>
    </div>
@endsection
