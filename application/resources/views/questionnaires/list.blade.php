@extends('layouts.app')

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
            {{-- @foreach($questionnaires as questionnaire)
                <tr>
                    <th scope="row">{{ questionnaire->title }}</th>
                    <td>{{ questionnaire->startdate }}  Tego jeszcze nie ma w bazie</td>
                    <td>{{ questionnaire->enddate }} Tego jeszcze nie ma w bazie</td>
                    <td>{{ questionnaire->status1 }} Tego jeszcze nie ma w bazie</td>
                    <td>{{ questionnaire->status2 }} Tego jeszcze nie ma w bazie</td>
                    <td>
                        <a href="{{ route('questionnaires.fill', questionnaire->id) }}">
                            <button class="btn btn-success btn-sm" title="Wypełnianie ankiety"><i class="far fa-edit"></i></button>
                        </a>
                    </td>
                </tr>
            @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
<script src="{{asset('/js/questionnaireslist.js')}}"></script>
@endsection