<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PartieAdverseRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PartieAdverseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PartieAdverseCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PartieAdverse::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/partie-adverse');
        CRUD::setEntityNameStrings('partie adverse', 'partie adverses');
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
        CRUD::column('nomprénom')->label('Nom complet (personnel ou entreprise)');
        CRUD::column('telephone');
        CRUD::column('adresse');
        CRUD::column('naturecontractant')->label('Nature de contractant');
        CRUD::column('tutelletiers')->label('Tutelle Tier');

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
        CRUD::setValidation(PartieAdverseRequest::class);

        CRUD::field('nomprénom')->label('Nom complet (personnel ou entreprise)');
        CRUD::field('email');
        CRUD::field('telephone');
        CRUD::field('adresse');
        CRUD::addField([
            'name'      => 'naturecontractant',
            'label'     => 'Nature de contractant',
            'type'      => 'enum',
        ],);
        CRUD::addField([
            'name'      => 'tutelletiers',
            'label'     => 'Tutelle Tier',
            'type'      => 'text',
        ],);
        CRUD::addField([
            'name'      => 'familletiers',
            'label'     => 'Famille Tier',
            'type'      => 'text',
        ],);
        CRUD::addField([
            'name'      => 'groupetiers',
            'label'     => 'Groupe Tier',
            'type'      => 'text',
        ],);
        CRUD::addField([
            'name'      => 'secteurtiers',
            'label'     => 'Secteur Tier',
            'type'      => 'enum',
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
