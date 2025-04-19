@extends('layouts.default')
@section('content')
    <div>
    </div>
    <div>
        {{ $user->name }}
    </div>
    <div>
        {{ $user->email }}
    </div>
    <div>

        <a class="bg-blue-500 text-white rounded" href="{{ url('/user-edit') }}">edit</a>
        <div></div>
        <form action="{{ url('/logout') }}" method="GET">
            <button class="bg-blue-500 text-white rounded">logout</button>
        </form>


    </div>
@endsection
@section('scripts')
@endsection
