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
                {{$latestAudience}}
            </div>
        </div>
    </div>       
</div>
<div class="row">
    <canvas id="myChart" style="display: block; box-sizing: border-box; height: 400px; width: 800px;"></canvas>
</div>
<div class="row">
    <canvas id="myChart2" style="display: block; box-sizing: border-box; height: 400px; width: 800px;"></canvas>
</div>

@endsection 

@section('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  fetch("{{ route('chart')}}")
  .then(response => response.json())
  .then(json => {
        new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [
                'Préparation',
                "à l\'inspection de travail",
                'au tribunal',
                'à la cour',
                'à la cour suprême',
                'Gagné',
                'Perdu',
            ],
            
          datasets: [
                {
                    label: 'Etat des affaires juridiques',
                    data: json.datasets,
                    borderWidth: 2
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
<script>
    const ctx2 = document.getElementById('myChart2');
  
    fetch("{{ route('chart')}}")
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
                      borderWidth: 2
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
