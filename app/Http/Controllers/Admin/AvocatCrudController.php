<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AvocatRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AvocatCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AvocatCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Avocat::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/avocat');
        CRUD::setEntityNameStrings('avocat', 'avocats');

        $user = backpack_user();
        $agency = $user->agence;

        // Super Admin can access all agencies
        if ($user->hasRole('Super Admin')) {
            return;
        }

        // Agency Consultant can only preview and list defendants associated with cases that belong to their agency
        if ($user->hasRole('Agence Consultant')) {
            $caseIds = $agency->dossierJustices()->pluck('id')->toArray();
            CRUD::addClause('whereIn', 'id', $caseIds);
            CRUD::denyAccess(['create', 'update', 'delete']);
            return;
        }

        // Agency Author or Admin can access, create, delete, and edit defendants associated with cases that belong to their agency
        if ($user->hasRole('Agence Author') || $user->hasRole('Agence Admin')) {
            $caseIds = $agency->dossierJustices()->pluck('id')->toArray();
            CRUD::addClause('whereIn', 'id', $caseIds);
            return;
        }

        // Deny access if none of the above conditions are met
        CRUD::denyAccess();
    }


    protected function setupShowOperation()
    {
        $this->setupListOperation();
        $this->autoSetupShowOperation();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('nomprénom')->label('Nom et Prénom');
        CRUD::column('email');
        CRUD::column('telephone');
        CRUD::column('adresse');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AvocatRequest::class);

        CRUD::field('nomprénom')->label('Nom et Prénom');
        CRUD::field('email');
        CRUD::field('telephone');
        CRUD::field('adresse');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
