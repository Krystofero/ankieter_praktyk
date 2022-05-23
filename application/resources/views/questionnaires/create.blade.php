@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h3 text-center">{{ __('Tworzenie nowej ankiety') }}</div>
                <div class="card-body">
                    <form method="post" action="{{ route('questionnairesModerator.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Tytuł</label>
                            <input name="title" id="title" class="form-control" type="text" aria-describedby="titleHelp" placeholder="Wprowadź tytuł" required autocomplete="title" autofocus>
                            <small id="titleHelp" class="form-text text-muted">Podaj unikalny tytuł ankiety.</small>

                            @error('title')
                                <small class="form-text text-danger">{{$message}}</small>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label for="startdate">Data początkowa</label>
                            <input name="startdate" id="startdate" class="form-control" type="date" aria-describedby="startdateHelp" placeholder="Wprowadź datę początkową" required autocomplete="startdate" autofocus>
                            <small id="startdateHelp" class="form-text text-muted">Data określająca początek możliwości wypełniania ankiety.</small>

                            @error('startdate')
                                <small class="form-text text-danger">{{$message}}</small>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label for="enddate">Data końcowa</label>
                            <input name="enddate" id="enddate" class="form-control" type="date" aria-describedby="enddateHelp" placeholder="Wprowadź datę końcową" required autocomplete="enddate" autofocus>
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
                                <button type="submit" class="btn btn-primary">Utwórz ankietę</button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{  route('questionnairesModerator.index') }}" class="btn btn-danger">
                                    {{ __('Anuluj') }}
                                </a>
                            </div>

                        {{-- <div class="d-flex justify-content-center links back">
                            <a href="{{url('/promocje')}}" style="color: #ff1111;">Powrót do strony głównej
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
