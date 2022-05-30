@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h3 text-center">{{ __('Edycja pytań ankiety:') }} {{ $questionnaire->title }}</div>
                <div class="card-body">
                    
                    

                    @foreach($questionnaire->questions as $question)

                    <div class="card mt-4 mb-3">
                        <div class="card-header h5">{{ $question->question }}</div>

                        <div class="card-body">
                            <ul class="list-group">
                                @if($question->type == "Otwarte")
                                <li class="list-group-item text-center">(Pytanie otwarte)</li>
                                @else
                                    @foreach($question->answers as $answer)
                                        <li class="list-group-item">{{ $answer->answer }}</li>
                                    @endforeach
                                @endif
                              </ul>
                        </div>

                        <div class="card-fotter col-md-2 mb-2 mt-0 text-center">
                            <form method="post" action="{{ $questionnaire->id }}/questions/{{ $question->id }}" >
                                @method('DELETE')
                                @csrf

                                <button type="submit" class="btn btn-sm btn-outline-danger delete" title="Usunięcie pytania">Usuń pytanie</button>
                            </form>
                        </div>

                        {{-- <button class="btn btn-danger btn-sm delete" title="Usunięcie pytania" data-id2="{{$questionnaire->id}}" data-id="{{ $question->id }}">
                            <i class="far fa-trash-alt"></i>
                        </button> --}}

                    </div>

                    @endforeach

                    <div class="form-group row mb-0 text-center">
                        <div class="col-md-6">
                            <a href="{{ route('questionnairesModerator.index') }}" class="btn btn-danger">
                                <i class="fas fa-arrow-left"></i>{{ __(' Powrót') }}
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-primary" href="{{url()->current()}}/questions/create">Dodaj nowe pytanie</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    $(document).ready(function () {
        $(function () {
            $('.delete').click(function () {
			  var _this = this;
		
			  Swal.fire({
			    title: "Czy na pewno chcesz usunąć pytanie?",
			    icon: 'warning',
			    showCancelButton: true,
			    confirmButtonText: 'Tak',
			    cancelButtonText: 'Nie'
			  }).then(function (result) {
			    if (result.value) {
			      $.ajax({
			        method: "DELETE",
			        url: "/questionnairesModerator/" + $(_this).data("id2") + "/questions/" + $(_this).data("id")
			      }).done(function (data) {
			        window.location.reload();
			      }).fail(function (data) {
			        // Swal.fire('Coś poszło nie tak...spróbuj ponownie później', data.responseJSON.message, data.responseJSON.status);
			      });
			    }
			  });
			});
	  	});
    });
</script> --}}

@endsection
