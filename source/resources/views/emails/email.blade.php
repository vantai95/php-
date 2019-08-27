@extends('layouts.email-template')

@section('content')
    <div class="text-justify">
        <p>{{$header}}, {{$full_name}}</p>
        <p>{{$body}}</p>
        <p>{{$footer}},</p>
        <h4>The Fishsauce</h4>
    </div>
@endsection