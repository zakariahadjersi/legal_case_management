@extends(backpack_view('blank'))

@php
    if (config('backpack.base.show_getting_started')) {
        $widgets['before_content'][] = [
            'type'        => 'view',
            'view'        => 'backpack::inc.getting_started',
        ];
    } else {/*
        $widgets['before_content'][] = /*[
            'type'        => 'jumbotron',
            'heading'     => trans('backpack::base.welcome'),
            'content'     => trans('backpack::base.use_sidebar'),
            'button_link' => backpack_url('logout'),
            'button_text' => trans('backpack::base.logout'),
                [
            'type'       => 'card',
            'wrapper'    => ['class' => 'col-sm-8 col-md-6'], 
            'content'    =>[
            'class'      => 'card bg-info text-center', 
            'header'     => 'Prochaine Audience', 
            'body'       => ,
            ]

        ];
    */ }
@endphp

@section('content')
<div class="row">
<div class="container-fluid animated fadeIn">

    <div class="col-sm-8 col-md-6">	
        <div class="card">
            <div class="card-header">Prochaine Audience</div>
            <div class="card-body">
                {{$latestAudience ?? 'aucune audience prévue'}}
            </div>
        </div>
    </div>       
</div>
<div style="margin-left: 100px;" class="row">
  <form class="form-group row" id="agenceForm">
    <label class="col-md-6 col-form-label" for="agenceSelect">Sélectionnez une agence :</label>
    <select class="form-control form-control-lg" id="agenceSelect" name="agence_id">
      <option value="0">Please select</option>
      @foreach($agences as $agence)
        <option value="{{ $agence->id }}">{{ $agence->nom }}</option>
      @endforeach
    </select>
    <button class="btn btn-square btn-block btn-secondary active" type="submit">Sélectionnez</button>
  </form>
    </div>
<div class="row">
  <canvas id="myChart" width="800" height="400" ></canvas>
</div>
<div class="row">
  <canvas id="myChart2" width="800" height="400" ></canvas>
</div>

@endsection 

@section('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');
  const form = document.getElementById('agenceForm');

  form.addEventListener('submit', function(event) {
    event.preventDefault();

    const agenceId = document.getElementById('agenceSelect').value;

    fetch("{{ route('chart') }}?agence_id=" + agenceId)
  .then(response => response.json())
  .then(json => {
        new Chart(ctx, {
        type: 'bar',
        data: {
          labels: json.labels,
          datasets: [
                {
                    label: 'Etat des affaires juridiques',
                    data: json.datasets,
                }
                ]
        },
        options: {
          responsive: true, // Allow the chart to be responsive
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
            ticks: {
                precision: 0
                }
            }
          }
        }
      });
});
  });
  
</script>
<script>
    const ctx2 = document.getElementById('myChart2');
    const form2 = document.getElementById('agenceForm');

form2.addEventListener('submit', function(event) {
  event.preventDefault();

  const agenceId = document.getElementById('agenceSelect').value;

  fetch("{{ route('chart') }}?agence_id=" + agenceId)
    .then(response => response.json())
    .then(json => {
          new Chart(ctx2, {
          type: 'bar',
          data: {
            labels: [
            'Commerciale','Personnel'
              ],
            datasets: [
                  {
                      label: 'Affaires juridiques par secteur',
                      data: json.datasets2,          
                  }
                  ]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true,
              ticks: {
                  precision: 0
                  }
              }
            }
          }
        });
  });
});    
</script>
  
@endsection 
