@extends('layouts.app')

@section('content')
    <edit-user id="{{ Auth::user()->id }}" :admin="false"></edit-user>
@endsection
