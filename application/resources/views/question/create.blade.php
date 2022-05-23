@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h3 text-center">{{ __('Tworzenie nowego pytania') }}</div>
                <div class="card-body">
                    <form method="post" action="/ankieter_praktyk/ankieter_praktyk/application/public/questionnairesModerator/{{ $questionnaire->id }}/questions">
                        @csrf
                        <div class="form-group">
                            <label for="question">Pytanie</label>
                            <input name="question[question]" id="question" class="form-control" value="{{old('question.question')}}" type="text" aria-describedby="questionHelp" placeholder="Wprowadź pytanie" required autocomplete="question" autofocus>
                            <small id="questionHelp" class="form-text text-muted">Zadaj odpowiednie pytanie.</small>

                            @error('question.question')
                                <small class="form-text text-danger">{{$message}}</small>
                            @enderror    
                        </div>
                        
                        <div class="form-group">
                            <fieldset>
                                <legend>Odpowiedzi</legend>
                                <small id="choicesHelp" class="form-text text-muted">Podaj możliwe odpowiedzi na twoje pytanie.</small>
                                <div>
                                    <div class="form-group">
                                        <label for="answer1">Odpowiedź nr 1</label>
                                        <input name="answers[][answer]" id="answer1" class="form-control" type="text" aria-describedby="answer1Help" placeholder="Wprowadź odpowiedź nr 1" required autocomplete="answer1" autofocus>
                                        <small id="answer1Help" class="form-text text-muted">Data określająca początek możliwości wypełniania ankiety.</small>
            
                                        @error('answers.0.answer')
                                            <small class="form-text text-danger">{{$message}}</small>
                                        @enderror    
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <label for="answer2">Odpowiedź nr 2</label>
                                        <input name="answers[][answer]" id="answer2" class="form-control" type="text" aria-describedby="answer2Help" placeholder="Wprowadź odpowiedź nr 2" required autocomplete="answer2" autofocus>
                                        <small id="answer2Help" class="form-text text-muted">Data określająca początek możliwości wypełniania ankiety.</small>
            
                                        @error('answers.1.answer')
                                            <small class="form-text text-danger">{{$message}}</small>
                                        @enderror    
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <label for="answer3">Odpowiedź nr 3</label>
                                        <input name="answers[][answer]" id="answer3" class="form-control" type="text" aria-describedby="answer3Help" placeholder="Wprowadź odpowiedź nr 3" required autocomplete="answer3" autofocus>
                                        <small id="answer3Help" class="form-text text-muted">Data określająca początek możliwości wypełniania ankiety.</small>
            
                                        @error('answers.2.answer')
                                            <small class="form-text text-danger">{{$message}}</small>
                                        @enderror    
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <label for="answer4">Odpowiedź nr 4</label>
                                        <input name="answers[][answer]" id="answer4" class="form-control" type="text" aria-describedby="answer4Help" placeholder="Wprowadź odpowiedź nr 4" required autocomplete="answer4" autofocus>
                                        <small id="answer4Help" class="form-text text-muted">Data określająca początek możliwości wypełniania ankiety.</small>
            
                                        @error('answers.3.answer')
                                            <small class="form-text text-danger">{{$message}}</small>
                                        @enderror    
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        
                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Utwórz pytanie</button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('questionnairesModerator.show',  $questionnaire->id) }}" class="btn btn-danger">
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
