@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h3 text-center">{{ __('Ankieta: ') }} {{ $questionnaire->title }}</div>
                <div class="card-body">
                    <form action="/questionnaires" method="post">
                        @csrf
                        {{-- <div class="form-group">
                            <label for="title">Tytuł</label>
                            <input name="title" id="title" class="form-control" type="text" aria-describedby="titleHelp" placeholder="Wprowadź tytuł">
                            <small id="titleHelp" class="form-text text-muted">Podaj unikalny tytuł ankiety.</small>
                        </div> --}}
                        {{-- Do wypełniania ankiety dla użytkownika: --}}
                        <div class="form-group">
                            <label for="studyfield">Kierunek studiów</label>
                            <input name="studyfield" id="studyfield" class="form-control" type="text" aria-describedby="studyfieldHelp" placeholder="Podaj kierunek studiów">
                        </div>
                        <div class="form-group">
                            <label for="year">Rok studiów</label>
                            <input name="year" id="year" class="form-control" type="number" aria-describedby="yearHelp" placeholder="Podaj rok studiów">
                        </div>
                        {{-- Pytania i udzielanie odpowiedzi --}}


                        <button type="submit" class="btn btn-primary">Wyślij odpowiedzi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
