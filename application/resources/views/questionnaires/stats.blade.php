@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h4">Statystyki ankiety: {{ $questionnaire->title }}</div>

                <div class="card-body">

                    <div class="card-body">
                    {{-- <div>{{ $questionnaireid}}</div> --}}
    
                        @foreach($questionnaire->questions as $question)
    
                        <div class="card mt-4 mb-0">
                            <div class="card-header h5">{{ $question->question }}</div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($question->answers as $answer)
                                        <li class="list-group-item">{{ $answer->answer }}</li>
                                    @endforeach
                                  </ul>
                            </div>
                        </div>
    
                        @endforeach
                    </div>
                        

                        <div class="form-group row mt-2 mb-0">
                            <div class="col-md-3">
                                <a href="{{ route('questionnairesModerator.index') }}" class="btn btn-danger">
                                    <i class="fas fa-arrow-left"></i>{{ __(' Powrót') }}
                                </a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection