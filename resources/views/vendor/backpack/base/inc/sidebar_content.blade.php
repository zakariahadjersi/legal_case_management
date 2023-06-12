{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@include('vendor.backpack.base.inc.sidebarMenuItem')
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-folder-open"></i> Gestion Des Affaires</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('partie-adverse') }}"><i class="nav-icon la la-user-times"></i><span>Partie adverses</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dossier-justice') }}"><i class="nav-icon la la-folder"></i><span>Dossier justices</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('audience') }}"><i class="nav-icon la la-calendar"></i><span>Audiences</span></a></li>
    </ul>
</li>    
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('avocat') }}"><i class="nav-icon la la-user-secret"></i> Avocats</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('court') }}"><i class="nav-icon la la-institution"></i> Courts</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>Gestion des Fichiers</span></a></li>
<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>