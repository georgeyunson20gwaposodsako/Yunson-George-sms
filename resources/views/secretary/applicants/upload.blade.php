@extends('layouts.app')

@section('title', 'Upload Documents')

@section('content')
    <h3 class="mb-4">Upload Documents for {{ $applicant->first_name }} {{ $applicant->last_name }}</h3>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('secretary.upload.save', $applicant->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">COR</label>
                    <input type="file" name="cor" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Certificate of Indigency</label>
                    <input type="file" name="indigency" class="form-control">
                </div>
                <button class="btn btn-primary" type="submit">Upload</button>
                <a href="{{ route('secretary.applicants') }}" class="btn btn-outline-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection
