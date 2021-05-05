@extends('layouts.app')

@section('content')
    <my-page username="{{ Auth::user()->name }}"></my-page>
@endsection
