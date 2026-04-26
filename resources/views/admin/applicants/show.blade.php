@extends('layouts.app')

@section('title', 'Applicant Details')

@section('content')
    <h3 class="mb-4">Applicant Details</h3>

    @php
        $status = $applicant->applications->first()->status ?? 'pending';
        $income = $applicant->family->total_parent_income ?? 0;
        $cor = $applicant->documents->firstWhere('document_type', 'cor');
        $indigency = $applicant->documents->firstWhere('document_type', 'indigency');
    @endphp

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $applicant->first_name }} {{ $applicant->last_name }}</p>
            <p><strong>School:</strong> {{ $applicant->school }}</p>
            <p><strong>Income:</strong> {{ number_format($income, 2) }}</p>
            <p><strong>Status:</strong> <span class="badge bg-secondary text-uppercase">{{ $status }}</span></p>
            <hr>
            <p><strong>Documents:</strong></p>
            <ul>
                <li>COR: {{ $cor && $cor->file_path ? 'Uploaded' : 'Not uploaded' }}</li>
                <li>Certificate of Indigency: {{ $indigency && $indigency->file_path ? 'Uploaded' : 'Not uploaded' }}</li>
            </ul>
            <a href="{{ route('admin.applicants') }}" class="btn btn-outline-secondary btn-sm">Back</a>
        </div>
    </div>
@endsection
