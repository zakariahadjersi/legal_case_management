{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dossier-justice') }}"><i class="nav-icon la la-question"></i> Dossier justices</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('avocat') }}"><i class="nav-icon la la-question"></i> Avocats</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('partie-adverse') }}"><i class="nav-icon la la-question"></i> Partie adverses</a></li>