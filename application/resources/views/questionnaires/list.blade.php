@extends('layouts.app')

@section('additives')
    @include('constant/dataTable')
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="row" id="titlerow">
            <div class="col-6 text-white">
                <h1><i class="fas fa-users"></i> {{ __('Lista ankiet') }}</h1>
            </div>
        </div>
        <table class="text-white display responsive nowrap" id="myTable" style="width:100%">
            <thead>
            <tr>
                <th scope="col">Tytuł</th>
                <th scope="col">Data początkowa</th>
                <th scope="col">Data końcowa</th>
                <th scope="col">Status ankiety</th>
                <th scope="col">Status wypełnienia</th>
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

                    {{-- Status wypełnienia ankiety: --}}
                    @if($questionnaire->filled == false) 
                        <td>Nie wypełniono</td>
                    @else
                        <td>Wypełniono</td>
                    @endif

                    <td class="text-center">
                        @if(($questionnaire->filled == false) && $questionnaire->enddate >= now()) 
                            <a href="{{ route('questionnaires.show', $questionnaire->questionnaire_id) }}">
                                <button class="btn btn-success btn-sm" title="Wypełnij ankietę"><i class="far fa-edit"></i></button>
                            </a>
                        @else
                            --Brak dostępnych akcji--
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="{{asset('/js/questionnaireslist.js')}}"></script>
@endsection