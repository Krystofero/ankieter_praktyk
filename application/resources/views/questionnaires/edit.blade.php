@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h4">Edycja ankiety: {{ $questionnaire->title }}</div>

                <div class="card-body">
                    {{-- <form method="POST" action="{{ route('questionnairesModerator.update', ['request' => $questionnaire->id ,'questionnaire' => $questionnaire->id]) }}"> --}}
                    <form method="POST" action="{{ route('questionnairesModerator.update', $questionnaire->id) }}">
                        {{ method_field('PUT') }}
                        @csrf

                        <div class="form-group">
                            <label for="title">Tytuł</label>
                            <input name="title" id="title" class="form-control" value="{{$questionnaire->title}}" type="text" aria-describedby="titleHelp" placeholder="Wprowadź tytuł" value="{{ $questionnaire->title }}" required autocomplete="title" autofocus>
                            <small id="titleHelp" class="form-text text-muted">Tytuł ankiety.</small>

                            @error('title')
                                <small class="form-text text-danger">{{$message}}</small>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label for="startdate">Data początkowa</label>
                            <input name="startdate" id="startdate" class="form-control" value="{{$questionnaire->startdate}}" type="date" aria-describedby="startdateHelp" placeholder="Wprowadź datę początkową" value="{{ $questionnaire->startdate }}" required autocomplete="startdate" autofocus>
                            <small id="startdateHelp" class="form-text text-muted">Data określająca początek możliwości wypełniania ankiety.</small>

                            @error('startdate')
                                <small class="form-text text-danger">{{$message}}</small>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label for="enddate">Data końcowa</label>
                            <input name="enddate" id="enddate" class="form-control" value="{{$questionnaire->enddate}}" type="date" aria-describedby="enddateHelp" placeholder="Wprowadź datę końcową" value="{{ $questionnaire->enddate }}" required autocomplete="enddate" autofocus>
                            <small id="enddateHelp" class="form-text text-muted">Data określająca koniec możliwości wypełniania ankiety.</small>

                            @error('enddate')
                                <small class="form-text text-danger">{{$message}}</small>
                            @enderror  
                        </div>

                        {{-- <div class="form-group">
                            <label for="pinusers">Podpięci użytkownicy</label>
                        </div> --}}

                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Zapisz') }}
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('questionnairesModerator.index') }}" class="btn btn-danger">
                                    {{ __('Anuluj') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection