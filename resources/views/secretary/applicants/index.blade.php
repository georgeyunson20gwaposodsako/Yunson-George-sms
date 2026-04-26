@extends('layouts.app')

@section('title', 'Secretary Applicants')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Applicants</h3>
        <a href="{{ route('secretary.applicants.create') }}" class="btn btn-primary btn-sm">Add Applicant</a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>School</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applicants as $applicant)
                        <tr>
                            <td>{{ $applicant->id }}</td>
                            <td>{{ $applicant->first_name }} {{ $applicant->last_name }}</td>
                            <td>{{ $applicant->school }}</td>
                            <td><span class="badge bg-secondary text-uppercase">{{ $applicant->applications->first()->status ?? 'pending' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('secretary.applicants.edit', $applicant->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="{{ route('secretary.upload', $applicant->id) }}" class="btn btn-sm btn-outline-success">Upload Docs</a>
                                <form method="POST" action="{{ route('secretary.applicants.delete', $applicant->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center p-4">No applicants found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
