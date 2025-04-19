@extends('layouts.default')
@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-12">
                    <div class="card-header">
                        <h3 class="card-title">User List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th style="width: 240px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $i)
                                    <tr class="align-middle">
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $i->name }}</td>
                                        <td>{{ $i->email }}</td>
                                        <td>{{ $i->role }}</td>
                                        <td>
                                            <a href="{{ url('/edit-user/' . $i->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ url('user') }}" class="d-inline-flex mb-0" method="POST">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="id" value="{{ $i->id }}">
                                                <button type="submit" class="btn btn-danger">Delete</button>
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

        <form action="{{ url('/user-edit') }}" method="POST">
            @csrf
            <div class="input-group mb-1">
                <div class="form-floating">
                    <input id="loginEmail" name="email" type="email" class="form-control" value=""
                        placeholder="" />
                    <label for="loginEmail">Email</label>
                </div>
                <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </div>
            <div class="input-group mb-1">
                <div class="form-floating">
                    <input id="registerPassword" name="password" type="password" class="form-control" placeholder="" />
                    <label for="registerPassword">Password</label>
                </div>
                <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            <div class="input-group mb-1">
                <div class="form-floating">
                    <input id="roles" name="role" type="text" class="form-control" placeholder="" />
                    <label for="roles">Role</label>
                </div>
                <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            <!--begin::Row-->
            <div class="row my-3 justify-content-center">
                <!-- /.col -->
                <div class="col-4">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
@endsection
