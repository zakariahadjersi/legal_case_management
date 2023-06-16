{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@include('vendor.backpack.base.inc.sidebarMenuItem')
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dossier-justice') }}"><i class="nav-icon la la-folder"></i><span>Dossier justices</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('audience') }}"><i class="nav-icon la la-calendar"></i><span>Audiences</span></a></li>   
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('partie-adverse') }}"><i class="nav-icon la la-user-times"></i><span>Partie adverses</span></a></li>
        @if (backpack_user()->hasRole('Super Admin') || backpack_user()->hasRole('Agence Admin') || backpack_user()->hasRole('Direction Admin'))
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('avocat') }}"><i class="nav-icon la la-user-secret"></i> Avocats</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('court') }}"><i class="nav-icon la la-institution"></i> Courts</a></li>
        @endif    
        @if (backpack_user()->hasRole('Super Admin')|| backpack_user()->hasRole('Direction Admin')|| backpack_user()->hasRole('Direction Consultant'))
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>Gestion des Fichiers</span></a></li>
        @endif
        <!-- Users, Roles, Permissions -->
@if (backpack_user()->hasRole('Super Admin') || backpack_user()->hasRole('Agence Admin') || backpack_user()->hasRole('Direction Admin'))
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Gestion Des Utilisateurs</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Utilisateurs</span></a></li>
        @if (backpack_user()->hasRole('Super Admin'))
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
        @endif
    </ul>
</li>
@endif