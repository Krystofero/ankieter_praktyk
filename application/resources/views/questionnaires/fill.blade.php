@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h3 text-center">{{ __('Ankieta: ') }} {{ $questionnaire->title }}</div>
                @if($questionnaire->description != null)
                    <div class="card-header">{{ __('Opis: ') }} {{ $questionnaire->description }}</div>
                @endif
                <div class="card-body">
                    <form action="{{ route('questionnaires.store', $questionnaire->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="questionnaire_id" value="{{ $questionnaire->id }}">
                        @foreach($questionnaire->questions as $key => $question)

                        <input type="hidden" name="responses[{{ $key }}][questionnaire_id]" value="{{ $questionnaire->id }}">
                        <input type="hidden" name="responses[{{ $key }}][question_id]" value="{{ $question->id }}">

                        <div class="card mt-4 mb-3">
                            <div class="card-header h5"><strong>{{ $key+1 }}. </strong>{{ $question->question }}</div>
    
                            <div class="card-body">

                                @error('responses.' . $key . '.answer_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <ul class="list-group">
                                    @if($question->type == "Otwarte")
                                        <textarea name="responses[{{ $key }}][answer_text]" id="answer{{ $key }}" cols="80" rows="3"></textarea>
                                    @else
                                        @foreach($question->answers as $answer)
                                        <label for="answer{{ $answer->id }}">
                                            <li class="list-group-item">
                                                <input type="radio" name="responses[{{ $key }}][answer_id]" id="answer{{ $answer->id }}"
                                                {{ (old('responses.' . $key . '.answer_id') == $answer->id) ? "checked" : "" }}
                                                value="{{ $answer->id }}" required>
                                                 {{ $answer->answer }}
                                                 
                                            </li>
                                        
                                        </label> 
                                        @endforeach
                                    @endif
                                  </ul>
                            </div>
                        </div>
    
                        @endforeach


                        {{-- <div class="form-group">
                            <label for="title">Tytuł</label>
                            <input name="title" id="title" class="form-control" type="text" aria-describedby="titleHelp" placeholder="Wprowadź tytuł">
                            <small id="titleHelp" class="form-text text-muted">Podaj unikalny tytuł ankiety.</small>
                        </div> --}}
                        {{-- Do wypełniania ankiety dla użytkownika: --}}
                        {{-- <div class="form-group">
                            <label for="studyfield">Kierunek studiów</label>
                            <input name="studyfield" id="studyfield" class="form-control" type="text" aria-describedby="studyfieldHelp" placeholder="Podaj kierunek studiów">
                        </div>
                        <div class="form-group">
                            <label for="year">Rok studiów</label>
                            <input name="year" id="year" class="form-control" type="number" aria-describedby="yearHelp" placeholder="Podaj rok studiów">
                        </div> --}}
                        {{-- Pytania i udzielanie odpowiedzi --}}

                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Wyślij odpowiedzi</button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('questionnaires.index') }}" class="btn btn-danger">
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
