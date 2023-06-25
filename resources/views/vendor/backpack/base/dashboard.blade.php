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
    <div class="col-md-6">
      <canvas id="myChart3" width="600" height="400"></canvas>
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
    const barColors = [
      'rgba(54, 162, 235, 0.5)',    // Color for 'en préparation'
      'rgba(153, 102, 255, 0.5)',    // Color for 'inspection de travail'
      'rgba(255, 206, 86, 0.5)',    // Color for 'au tribunal'
      'rgba(255, 159, 64, 0.5)',    // Color for 'à la cour'
      'rgba(255, 99, 132, 0.5)',   // Color for 'à la cour suprême'
      'rgba(75, 192, 192, 0.5)',    // Color for 'Gagné'
      'rgba(255, 0, 0, 0.5)'        // Color for 'Perdu'
    ];
        new Chart(ctx, {
        type: 'bar',
        data: {
          labels: json.labels,
          datasets: [
                {
                    label: 'Etat des affaires juridiques',
                    data: json.datasets,
                    backgroundColor: [
      'rgba(255, 159, 64, 0.5)',    // Color for 'en préparation'
      'rgba(54, 162, 235, 0.5)',    // Color for 'inspection de travail'
      'rgba(255, 206, 86, 0.5)',    // Color for 'au tribunal'
      'rgba(153, 102, 255, 0.5)',    // Color for 'à la cour'
      'rgba(255, 0, 0, 0.5)',   // Color for 'à la cour suprême'
      'rgba(75, 192, 192, 0.5)',    // Color for 'Gagné'
      'rgba(255, 99, 132, 0.5)'       // Color for 'Perdu'
    ],
                    borderColor: [
      'rgba(54, 162, 235, 0.5)',    // Color for 'en préparation'
      'rgba(255, 159, 64, 0.5)',    // Color for 'inspection de travail'
      'rgba(255, 206, 86, 0.5)',    // Color for 'au tribunal'
      'rgba(153, 102, 255, 0.5)',    // Color for 'à la cour'
      'rgba(255, 0, 0, 0.5)',        // Color for 'à la cour suprême'
      'rgba(75, 192, 192, 0.5)',    // Color for 'Gagné'
      'rgba(255, 99, 132, 0.5)'       // Color for 'Perdu'
    ],
                    borderWidth: 1,
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
                      backgroundColor: [
                      'rgba(255, 99, 132, 0.5)',
                      'rgba(54, 162, 235, 0.5)'
                      ],
                      borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)'
                      ],
                      borderWidth: 1          
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
  const ctx3 = document.getElementById('myChart3');
fetch("{{ route('chart') }}")
  .then(response => response.json())
  .then(json => {
    const pieColors = [
      'rgba(255, 159, 64, 0.5)',    // Color for 'en préparation'
      'rgba(54, 162, 235, 0.5)',    // Color for 'inspection de travail'
      'rgba(255, 206, 86, 0.5)',    // Color for 'au tribunal'
      'rgba(153, 102, 255, 0.5)',    // Color for 'à la cour'
      'rgba(255, 0, 0, 0.5)',   // Color for 'à la cour suprême'
      'rgba(75, 192, 192, 0.5)',    // Color for 'Gagné'
      'rgba(255, 99, 132, 0.5)'       // Color for 'Perdu'
    ];

    // Extract labels and datasets from the response
    const labels = json.labels;
    const datasets = Object.values(json.datasets);

    // Prepare data for the pie chart
    const pieData = datasets.map((value, index) => ({
      label: labels[index],
      value: value,
      backgroundColor: pieColors[index],
      borderColor: pieColors[index].replace('0.5', '1'),
      borderWidth: 1
    }));

    new Chart(ctx3, {
      type: 'pie',
      data: {
        labels: pieData.map(data => data.label),
        datasets: [{
          data: pieData.map(data => data.value),
          backgroundColor: pieData.map(data => data.backgroundColor),
          borderColor: pieData.map(data => data.borderColor),
          borderWidth: 1,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          tooltip: {
            callbacks: {
              label: function (context) {
                const label = context.label || '';
                const value = context.raw || 0;
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const percentage = ((value / total) * 100).toFixed(2);
                return label + ': ' + value + ' (' + percentage + '%)';
              },
            },
          },
          legend: {
            position: 'right',
            align: 'center',
            labels: {
              usePointStyle: true,
            }
          }
        }
      }
    });
  });

</script>  
@endsection 
