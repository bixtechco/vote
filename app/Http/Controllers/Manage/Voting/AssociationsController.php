<?php

namespace App\Http\Controllers\Manage\Voting;

use Src\Auth\Ability;
use Src\Voting\Association;
use App\Http\Controllers\ManageAuthedController;
use App\Http\Requests\Manage\Voting\Associations\QueryRequest;

class AssociationsController extends ManageAuthedController
{
    /**
     * Get the permissions that apply to the controller.
     *
     * @return array
     */
    protected function permissions()
    {
        return [
          Ability::MANAGE_ROOTS,
          Ability::MANAGE_ASSOCIATIONS,
        ];
    }

    /**
     * List action
     *
     * @param \App\Http\Requests\Manage\Voting\Associations\QueryRequest $queried
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(QueryRequest $queried)
    {
        $associations = $queried->query()->latest()->paginate(20);

        return view('manage.voting.associations.list', compact('associations'))->with([
            'filters' => $queried->filters(),
        ]);
    }

    //show
    public function show($id)
    {
        $association = Association::findOrFail($id);

        return view('manage.voting.associations.show', compact('association'));
    }
}
