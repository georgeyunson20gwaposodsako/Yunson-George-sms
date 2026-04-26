@extends('layouts.app')

@section('title', 'Add Applicant')

@section('content')
    <h3 class="mb-4">Add Applicant</h3>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('secretary.applicants.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">School</label>
                        <input type="text" name="school" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Income</label>
                        <input type="number" step="0.01" name="income" class="form-control" required>
                    </div>
                </div>
                <button class="btn btn-primary mt-3" type="submit">Save Applicant</button>
            </form>
        </div>
    </div>
@endsection
