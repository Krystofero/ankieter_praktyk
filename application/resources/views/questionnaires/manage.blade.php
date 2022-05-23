@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="row" id="titlerow">
            <div class="col-6 text-white">
                <h1><i class="fas fa-users"></i> {{ __('Zarządzanie ankietami') }}</h1>
            </div>
        </div>
        <table class="text-white display responsive nowrap" id="myTable" style="width:100%">
            <thead>
            <tr>
                <th scope="col">Tytuł</th>
                <th scope="col">Data początkowa</th>
                <th scope="col">Data końcowa</th>
                <th scope="col">Status</th>
                <th scope="col">Akcje</th>
            </tr>
            </thead>
            <tbody class="text-dark">
            @foreach($questionnaires as $questionnaire)
                <tr>
                    <th scope="row">{{ $questionnaire->title }}</th>
                    <td>{{ $questionnaire->startdate }}</td>
                    <td>{{ $questionnaire->enddate }}</td>
                    {{-- Status ankiety: --}}
                    @if($questionnaire->startdate > now()) 
                        <td>Nie rozpoczęto</td>
                    @elseif ($questionnaire->enddate < now())
                        <td>Zakończono</td>
                    @else
                        <td>W trakcie</td>
                    @endif
                    {{-- <td>{{ $questionnaire->status1 }}</td> --}}
                    <td>
                        @if(!($questionnaire->startdate > now()))
                            {{-- wzorować się na edit --}}
                            <a href="{{url('/questionnairesModerator/stats/')}}/{{$questionnaire->id}}">
                                <button class="btn btn-info btn-sm" title="Statystyki ankiety"><i class="far fa-newspaper"></i></button>
                            </a>
                        @elseif($questionnaire->startdate > now())
                            {{-- Widok z edycją pytań - dostępny dopuki się nie rozpoczęła ankieta --}}
                            <a href="{{ route('questionnairesModerator.show',  $questionnaire->id) }}">
                                <button class="btn btn-info btn-sm" title="Edycja pytań ankiety"><i class="fas fa-question"></i></button>
                            </a>
                        @endif
                        <a href="{{ route('questionnairesModerator.edit', $questionnaire->id) }}">
                            <button class="btn btn-success btn-sm" title="Edycja ankiety"><i class="far fa-edit"></i></button>
                        </a>
                        {{-- Opcjonalne usuwanie ankiety --}}
                        {{-- <button class="btn btn-danger btn-sm delete" title="Usunięcie ankiety" data-id="{{ $questionnaire->id }}">
                            <i class="far fa-trash-alt"></i>
                        </button> --}}
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot style="color: #fff;">
                <tr>
                  <td>
                    <a href="{{ route('questionnairesModerator.create') }}">
                        <button class="border border-secondary btn btn-primary" style="color: white;"><i class="far fa-edit"></i>Utwórz nową ankietę</button>
                    </a>
                  </td>
                </tr>
              </tfoot>
        </table>
    </div>
</div>
<script type="text/javascript" > const deleteUrl = "{{ url('questionnairesModerator') }}/"; </script>
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}
<script src="{{asset('/js/questionnairesmanage.js')}}"></script>
@endsection