@extends('layouts.parent')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">List User</h5>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Roles</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $row)
                            <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->name }}</td>
                            <td>
                                @if ($row->roles == 'ADMIN')
                                    <span class="badge bg-danger">{{ $row->roles }}</span>
                                @else
                                    <span class="badge bg-primary">{{ $row->roles }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dashboard.user.edit', $row->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('dashboard.user.destroy', $row->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
