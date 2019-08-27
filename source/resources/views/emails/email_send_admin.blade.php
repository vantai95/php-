@extends('layouts.email-template')

@section('content')
    <div class="text-justify">
        <p>{{$salutation}}</p>
        <p>{{$header}}</p>
        <p>{{$content}}</p>
        <p>{{$footer}}</p>
        <p>{{$closing}}</p>
        <h4>{{$signature}}</h4>
    </div>
@endsection