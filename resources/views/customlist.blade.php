@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.list') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
  <div class="container-fluid">
    <h2>
      <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
      <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
    </h2>
  </div>
@endsection

@section('content')
  {{-- Default box --}}
  <div class="row">

    {{-- THE ACTUAL CONTENT --}}
    <div class="{{ $crud->getListContentClass() }}">

        <div class="row mb-0">
          <div class="col-sm-6">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">

                @include('crud::inc.button_stack', ['stack' => 'top'])

              </div>
            @endif
          </div>
          <div class="col-sm-6">
            <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none"></div>
          </div>
        </div>

        {{-- Backpack List Filters --}}
        @if ($crud->filtersEnabled())
          @include('crud::inc.filters_navbar')
        @endif
       
        <!-- Secteur Filter -->
          <div class="row mt-2">
            <div class="col-md-2">
              <label for="secteur_filter">Filtrer par Secteur:</label>
              <select id="secteur_filter" name="secteurs" class="form-control bg-secondary mb-1" >
                <option value="{{ url($crud->route) }}" >Tous</option>
                <!-- Add options here based on your 'secteurs' enum values -->
                <option value="{{ url($crud->route . '?filter_secteur=' . urlencode('Personnel')) }}"  {{ request('filter_secteur') == 'Personnel' ? 'selected' : '' }}>Personnel</option>
                <option value="{{ url($crud->route . '?filter_secteur=' . urlencode('Commerciale')) }}" {{ request('filter_secteur') == 'Commerciale' ? 'selected' : '' }}>Commerciale</option>
              </select>
            </div>
            <div class="col-md-2">
              <!-- State Filter -->
              <label for="state_filter">Filtrer par Etat:</label>
              <select id="state_filter" name="states" class="form-control bg-secondary mb-1">
                <option value="{{ url($crud->route) }}">Tous</option>
                <!-- Add options here based on your 'states' enum values -->
                <option value="{{ url($crud->route . '?filter_state=' . urlencode('en préparation')) }}" {{ request('filter_state') == 'en préparation' ? 'selected' : '' }}>en préparation</option>
                <option value="{{ url($crud->route . '?filter_state=' . urlencode('à l\'inspection de travail')) }}" {{ request('filter_state') == 'à l\'inspection de travail' ? 'selected' : '' }}>à l'inspection de travail</option>
                <option value="{{ url($crud->route . '?filter_state=' . urlencode('au tribunal')) }}" {{ request('filter_state') == 'au tribunal' ? 'selected' : '' }}>au tribunal</option>
                <option value="{{ url($crud->route . '?filter_state=' . urlencode('à la cour')) }}" {{ request('filter_state') == 'à la cour' ? 'selected' : '' }}>à la cour</option>
                <option value="{{ url($crud->route . '?filter_state=' . urlencode('à la cour suprême')) }}" {{ request('filter_state') == 'à la cour suprême' ? 'selected' : '' }}>à la cour suprême</option>
                <option value="{{ url($crud->route . '?filter_state=' . urlencode('Gagné')) }}" {{ request('filter_state') == 'Gagné' ? 'selected' : '' }}>Gagné</option>
                <option value="{{ url($crud->route . '?filter_state=' . urlencode('Perdu')) }}" {{ request('filter_state') == 'Perdu' ? 'selected' : '' }}>Perdu</option>
              </select>
            </div>
          </div>
        <table
          id="crudTable"
          class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2"
          data-responsive-table="{{ (int) $crud->getOperationSetting('responsiveTable') }}"
          data-has-details-row="{{ (int) $crud->getOperationSetting('detailsRow') }}"
          data-has-bulk-actions="{{ (int) $crud->getOperationSetting('bulkActions') }}"
          data-has-line-buttons-as-dropdown="{{ (int) $crud->getOperationSetting('lineButtonsAsDropdown') }}"
          cellspacing="0">
            <thead>
              <tr>
                {{-- Table columns --}}
                @foreach ($crud->columns() as $column)
                  <th
                    
                    data-orderable="{{ var_export($column['orderable'], true) }}"
                    data-priority="{{ $column['priority'] }}"
                    data-column-name="{{ $column['name'] }}"
                    {{--
                    data-visible-in-table => if developer forced field in table with 'visibleInTable => true'
                    data-visible => regular visibility of the field
                    data-can-be-visible-in-table => prevents the column to be loaded into the table (export-only)
                    data-visible-in-modal => if column apears on responsive modal
                    data-visible-in-export => if this field is exportable
                    data-force-export => force export even if field are hidden
                    --}}

                    {{-- If it is an export field only, we are done. --}}
                    @if(isset($column['exportOnlyField']) && $column['exportOnlyField'] === true)
                      data-visible="false"
                      data-visible-in-table="false"
                      data-can-be-visible-in-table="false"
                      data-visible-in-modal="false"
                      data-visible-in-export="true"
                      data-force-export="true"
                    @else
                      data-visible-in-table="{{var_export($column['visibleInTable'] ?? false)}}"
                      data-visible="{{var_export($column['visibleInTable'] ?? true)}}"
                      data-can-be-visible-in-table="true"
                      data-visible-in-modal="{{var_export($column['visibleInModal'] ?? true)}}"
                      @if(isset($column['visibleInExport']))
                         @if($column['visibleInExport'] === false)
                           data-visible-in-export="false"
                           data-force-export="false"
                         @else
                           data-visible-in-export="true"
                           data-force-export="true"
                         @endif
                       @else
                         data-visible-in-export="true"
                         data-force-export="false"
                       @endif
                    @endif
                  >
                    {{-- Bulk checkbox --}}
                    @if($loop->first && $crud->getOperationSetting('bulkActions'))
                      {!! View::make('crud::columns.inc.bulk_actions_checkbox')->render() !!}
                    @endif
                    {!! $column['label'] !!}
                  </th>
                @endforeach

                @if ( $crud->buttons()->where('stack', 'line')->count() )
                  <th data-orderable="false"
                      data-priority="{{ $crud->getActionsColumnPriority() }}"
                      data-visible-in-export="false"
                      data-action-column="true"
                      >{{ trans('backpack::crud.actions') }}</th>
                @endif
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                {{-- Table columns --}}
                @foreach ($crud->columns() as $column)
                  <th>
                    {{-- Bulk checkbox --}}
                    @if($loop->first && $crud->getOperationSetting('bulkActions'))
                      {!! View::make('crud::columns.inc.bulk_actions_checkbox')->render() !!}
                    @endif
                    {!! $column['label'] !!}
                  </th>
                @endforeach

                @if ( $crud->buttons()->where('stack', 'line')->count() )
                  <th>{{ trans('backpack::crud.actions') }}</th>
                @endif
              </tr>
            </tfoot>
          </table>

          @if ( $crud->buttons()->where('stack', 'bottom')->count() )
          <div id="bottom_buttons" class="d-print-none text-center text-sm-left">
            @include('crud::inc.button_stack', ['stack' => 'bottom'])

            <div id="datatable_button_stack" class="float-right text-right hidden-xs"></div>
          </div>
          @endif

    </div>

  </div>

@endsection

@section('after_styles')
  {{-- DATA TABLES --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

  {{-- CRUD LIST CONTENT - crud_list_styles stack --}}
  @stack('crud_list_styles')
@endsection

@section('after_scripts')
  @include('crud::inc.datatables_logic')

  {{-- CRUD LIST CONTENT - crud_list_scripts stack --}}
  @stack('crud_list_scripts')
  {{-- Secteur Filter Logic --}}
  <script>
  document.getElementById('secteur_filter').addEventListener('change', function() {
  let selectedValue = this.value;
 

  if (selectedValue === "{{ url($crud->route) }}") {
    
    // If "All" is selected, remove the filter parameter from the URL and reload the page to show all items.
    const url = new URL(window.location.href);
    url.searchParams.delete("filter_secteur");
    
    window.location.href = url.toString();
  } else {
    
    window.location.href = selectedValue;
  }
  });
  document.getElementById('state_filter').addEventListener('change', function() {
    let selectedValue = this.value;
    
	if (selectedValue === "{{ url($crud->route) }}") {
		location.replace("{{ url($crud->route) }}");
	} else {
		location.href = selectedValue;
	}
  });

  </script>
  
@endsection
