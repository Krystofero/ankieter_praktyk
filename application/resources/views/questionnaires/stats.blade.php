@extends('layouts.app')

@section('additives')
   <!-- tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Echarts -->
    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4">Statystyki ankiety: {{ $questionnaire->title }}</div>

                <div class="card-body">

                    <div class="card-body">
                    {{-- <div>{{ $questionnaireid}}</div> --}}
    
                        @foreach($questionnaire->questions as $question)
    
                        <div class="card mt-4 mb-0 text-center">
                            <div class="card-header h5">{{ $question->question }}</div>
                            <div class="form-group row mb-0 text-center">
                                <div class="card-body col-md-6">
                                    <ul class="list-group">
                                        @if($question->type == "Otwarte")
                                            @foreach($question->responses as $response)
                                                @if($response->answer_text != null)
                                                    <li class="list-group-item">{{ $response->answer_text }}</li>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($question->answers as $answer)
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <div>{{$alphas[$loop->iteration - 1]}}) {{ $answer->answer }}</div>
                                                    @if($question->responses->count())
                                                        <div>{{ intval(($answer->responses->count() * 100) / $question->responses->count()) }}%</div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                @if($question->type == "Zamkniete" && $question->responses->count())
                                    <div class="col-md-6">
                                        <div id="chart{{$question->id}}" style="height: 250px;"></div>
                                    </div>
                                @endif
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

<script>
    //inicjalizacja zmiennych:
    let var1 = null;
    let labels1 = null;
    let datasets1 = null;
    let chart = null;
    @foreach($questionnaire->questions as $question)
        @if($question->type == "Zamkniete" && $question->responses->count())
            var1 = {!! $answers_chart[$loop->iteration - 1] !!}; //przekazanie obiektu JSON z danymi do wykresów PHP
            labels1 = var1['chart']['labels'];  //labels wykresu
            datasets1 = var1['datasets'];        //datasets wykresu

            chart = new Chartisan({
                el: '#chart'+{{$question->id}},
                // url: "/ankieter_praktyk/ankieter_praktyk/application/public/api/chart/answers_chart",
                // url: "@chart('answers_chart')", //To samo
                data:{
                    chart: { labels: labels1 },
                    datasets: datasets1,
                },
                hooks: new ChartisanHooks()
                    .tooltip()
                    .colors(['#d64161', '#ECC94B', '#4299E1'])
                    .legend({ position: 'bottom' })
                    // .datasets([
                    //     { type: 'pie', radius: ['40%', '60%'] },
                    //     { type: 'pie', radius: ['10%', '30%'] },
                    //     ]),
                    // .pieColors(),
                    .title('Statystyki:')
                    // .datasets([{ type: 'line', fill: false }, 'bar']),
            });
        @endif
    @endforeach

</script>

@endsection