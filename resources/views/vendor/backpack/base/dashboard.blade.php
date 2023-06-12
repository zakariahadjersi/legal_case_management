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
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Prochaine Audience</div>
        <div class="card-body">
          {{$latestAudience ?? 'aucune audience prévue'}}
          {{$latestAudienceHeure}}
          {{$latestAudienceCour}}
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center mt-4">
    <div class="col-md-6">
      <canvas id="myChart" width="600" height="400"></canvas>
    </div>
    <div class="col-md-6">
      <canvas id="myChart2" width="600" height="400"></canvas>
    </div>
  </div>
</div>




@endsection 

@section('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');
    fetch("{{ route('chart') }}")
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
</script>
<script>
    const ctx2 = document.getElementById('myChart2');
     fetch("{{ route('chart') }}")
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
</script>
  
@endsection 
