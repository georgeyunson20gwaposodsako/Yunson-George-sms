@extends('layouts.app')

@section('title', 'All Applicants')

@section('content')
    <h3 class="mb-4">All Applicants</h3>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>School</th>
                        <th>Income</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applicants as $applicant)
                        @php
                            $status = $applicant->applications->first()->status ?? 'pending';
                            $income = $applicant->family->total_parent_income ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $applicant->id }}</td>
                            <td>{{ $applicant->first_name }} {{ $applicant->last_name }}</td>
                            <td>{{ $applicant->school }}</td>
                            <td>{{ number_format($income, 2) }}</td>
                            <td><span class="badge bg-secondary text-uppercase">{{ $status }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.applicants.show', $applicant->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                <form method="POST" action="{{ route('admin.approve', $applicant->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.reject', $applicant->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">No applicants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
