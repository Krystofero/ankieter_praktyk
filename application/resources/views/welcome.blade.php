{{-- <!DOCTYPE html>
<html>
<head>
    @include('constant/head')
</head>
<body>
    <div class="maindiv">
        @include('constant/navigationBar')
        <div id="welcome">
            <h1><span>Witaj</span></h1>
        </div>
    </div>
    @include('constant/footer')
</body>
</html>
 --}}

@extends('layouts.app')

@section('content')
<div id="welcome">
    <h1><span>Witaj</span></h1>
</div>
@endsection
