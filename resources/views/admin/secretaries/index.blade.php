@extends('layouts.app')

@section('title', 'Manage Secretaries')

@section('content')
    <h3 class="mb-4">Manage Secretary Accounts</h3>

    <div class="row g-3">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Add Secretary</h5>
                    <form method="POST" action="{{ route('admin.secretaries.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($secretaries as $secretary)
                                <tr>
                                    <td>{{ $secretary->name }}</td>
                                    <td>{{ $secretary->email }}</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('admin.secretaries.delete', $secretary->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center p-4">No secretary accounts yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
