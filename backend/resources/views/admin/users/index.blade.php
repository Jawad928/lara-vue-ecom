@extends('admin.layouts.app')
@section('title')
    Users
@endsection


@section('content')
    <div class="row">
        @include('admin.layouts.sidebar')
        <div class="col-md-9">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card-header bg-white ">
                        <h3 class="mt-2">
                            Users({{ $users->count() }})
                        </h3>

                    </div>
                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Profile Image</th>
                                    <th>Registered</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ $key += 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>

                                        <td><img src="{{ $user->image_path }}" alt="" width="60" height="60"
                                                alt="{{ $user->name }}" class="rounded"></td>


                                        <td>
                                            {{ $user->created_at->diffForHumans() }}
                                        </td>


                                        <td class="d-flex">
                                            <a href="#" onclick="deleteItem('{{ $user->id }}')"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>

                                        <form id="{{ $user->id }}"
                                            action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
