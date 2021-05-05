@extends('layouts.app')

@section('content')
    <edit-user id="{{ $id }}" :admin="true"></edit-user>
@endsection
