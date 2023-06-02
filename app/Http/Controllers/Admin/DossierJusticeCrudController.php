<?php

namespace App\Http\Controllers\Admin;

use App\Models\Avocat;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DossierJusticeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


/**
 * Class DossierJusticeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DossierJusticeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\DossierJustice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/dossier-justice');
        CRUD::setEntityNameStrings('dossier justice', 'dossier justices');

        $user = backpack_user();
        $agency = $user->agence_id;

        // Super Admin can access all agencies
        if ($user->hasRole('Super Admin')) {
            return;
        }

        // Agency Consultant can only preview and list items that belong to their agency
        if ($user->hasRole('Agence Consultant')) {
            CRUD::addClause('where', 'agence_id', '=', $agency);
            CRUD::denyAccess(['create', 'update', 'delete']);
            return;
        }

        // Agency Author or Admin can access, create, delete, and edit items that belong to their agency
        if ($user->hasRole('Agence Author') || $user->hasRole('Agence Admin')) {
            CRUD::addClause('where', 'agence_id', '=', $agency);
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
    
        CRUD::column('code_affaire');
        CRUD::addColumn([
            'name'      => 'partie_adverse_id',
            'label'     => 'Partie Adverse',
            'type'      => 'select',
            'attribute' => 'nomprénom',
            'entity'    => 'partieAdverse',
        ],);
        CRUD::column('state')->label('Etat');

        CRUD::column('secteur');
        CRUD::column('date_fin');
        

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
        
        CRUD::setValidation(DossierJusticeRequest::class);
        
        CRUD::field('code_affaire');
        CRUD::addField([
            'name'  => 'state',
            'label' => 'Etat',
            'type'  => 'enum',
        ],);
        
        CRUD::addField([
            'name'  => 'secteur',
            'label' => 'Secteur',
            'type'  => 'enum',
        ],);
        
        CRUD::addField([
            'name'      => 'partie_adverse_id',
            'label'     => 'Partie Adverse',
            'type'      => 'select',
            'attribute' => 'nomprénom',
            'entity'    => 'partieAdverse',
        ],);
        CRUD::addField([
            'name'      => 'avocat_id',
            'label'     => 'Avocat',
            'type'      => 'select',
            'attribute' => 'nomprénom',
            'entity'    => 'avocat',
        ],);
        CRUD::field('budget');
        CRUD::field('date_fin');
        CRUD::addField([
            'name'  => 'user_id',
            'type'  => 'hidden',
            'value' => backpack_user()->id,
        ],);
        CRUD::addField([
            'name'  => 'agence_id',
            'type'  => 'hidden',
            'value' => backpack_user()->agence->id,
        ],);
    
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
