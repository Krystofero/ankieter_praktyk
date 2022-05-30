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
                        <div class="row mb-3">
                            <label for="sel" class="col-md-2 col-form-label text-md-end"><i class="fas fa-question"></i> {{ __('Wybierz typ pytania:') }} </label>
                            <div class="col-md-8">
                                <select onchange="typeChange(sel)" class="form-select" aria-label=".form-select-lg example" name="type" id="sel">
                                        <option value="Zamkniete" selected>Zamknięte</option>
                                        <option value="Otwarte">Otwarte</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="closed">
                            <fieldset>
                                <legend>Odpowiedzi</legend>
                                <small id="choicesHelp" class="form-text text-muted">Podaj możliwe odpowiedzi na twoje pytanie.</small>
                                <div class="answers" id="answers">
                                    {{-- <div>
                                        <div class="form-group" id="ans1">
                                            <label for="answer1">Odpowiedź nr 1</label>
                                            <input name="answers[][answer]" id="answer1" class="form-control" type="text" aria-describedby="answer1Help" placeholder="Wprowadź odpowiedź nr 1" required autocomplete="answer1" autofocus>
                                            <small id="answer1Help" class="form-text text-muted">Data określająca początek możliwości wypełniania ankiety.</small>
                
                                            @error('answers.0.answer')
                                                <small class="form-text text-danger">{{$message}}</small>
                                            @enderror    
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group" id="ans2">
                                            <label for="answer2">Odpowiedź nr 2</label>
                                            <input name="answers[][answer]" id="answer2" class="form-control" type="text" aria-describedby="answer2Help" placeholder="Wprowadź odpowiedź nr 2" required autocomplete="answer2" autofocus>
                                            <small id="answer2Help" class="form-text text-muted">Data określająca początek możliwości wypełniania ankiety.</small>
                
                                            @error('answers.1.answer')
                                                <small class="form-text text-danger">{{$message}}</small>
                                            @enderror    
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group" id="ans3">
                                            <label for="answer3">Odpowiedź nr 3</label>
                                            <input name="answers[][answer]" id="answer3" class="form-control" type="text" aria-describedby="answer3Help" placeholder="Wprowadź odpowiedź nr 3" required autocomplete="answer3" autofocus>
                                            <small id="answer3Help" class="form-text text-muted">Data określająca początek możliwości wypełniania ankiety.</small>
                
                                            @error('answers.2.answer')
                                                <small class="form-text text-danger">{{$message}}</small>
                                            @enderror    
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group" id="ans4">
                                            <label for="answer4">Odpowiedź nr 4</label>
                                            <input name="answers[][answer]" id="answer4" class="form-control" type="text" aria-describedby="answer4Help" placeholder="Wprowadź odpowiedź nr 4" required autocomplete="answer4" autofocus>
                                            <small id="answer4Help" class="form-text text-muted">Data określająca początek możliwości wypełniania ankiety.</small>
                
                                            @error('answers.3.answer')
                                                <small class="form-text text-danger">{{$message}}</small>
                                            @enderror    
                                            <button onclick="deleteAnswer(ans4)" id="del4" class="mt-1 btn btn-sm btn-outline-danger delete" title="Usunięcie odpowiedzi">Usuń odpowiedź</button>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-md-2 mb-2 mt-0 text-center">
                                    <button onclick="addNew()" class="btn btn-sm btn-outline-info" id="addnewanswer" title="Dodanie nowej odpowiedzi">Dodaj odpowiedź</button>
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

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let ans_number = 1;
    function addNew() {
            var ans = $('#answers');
            $('#answers').append('<div class="form-group" id="ans'+ ans_number +'"><label for="answer'+ ans_number +'">Odpowiedź nr '+
                 ans_number +'</label><input name="answers[][answer]" id="answer'+
                  ans_number +'" class="form-control" type="text" aria-describedby="answer1Help" placeholder="Wprowadź odpowiedź nr '+
                   ans_number +'" required autocomplete="answer'+ ans_number +'" autofocus> @error("answers.'+
                     (ans_number-1) +'.answer")<small class="form-text text-danger">{{$message}}</small>@enderror    <button onclick="deleteAnswer(ans'+
                      ans_number +')" id="del'+ ans_number +'" class="mt-1 btn btn-sm btn-outline-danger delete" title="Usunięcie odpowiedzi">Usuń odpowiedź</button></div>');
            if(ans_number > 1){
                $("#del"+(ans_number-1)).hide();
                // $("#del"+(ans_number-1)).remove();
            }
            ans_number++;
        }
    function deleteAnswer(id) {
        $(id).remove();
        ans_number--;
        if(ans_number > 1){
            $("#del"+(ans_number-1)).show();
        }
    }
    function typeChange(id) {
        var choice = $(id).find(":selected").text();
        console.log(choice);
        if(choice == "Otwarte"){
            $("#closed").hide();
        }
        else $("#closed").show();
    }
</script>
@endsection
