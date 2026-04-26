@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h3 class="mb-4">Admin Dashboard</h3>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Total Applicants</h6>
                    <h3>{{ $totalApplicants }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Approved</h6>
                    <h3>{{ $approvedCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Pending</h6>
                    <h3>{{ $pendingCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Rejected</h6>
                    <h3>{{ $rejectedCount }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
