<?php

namespace App\Http\Controllers\Main\Voting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\Voting\Association\StoreRequest;
use App\Http\Requests\Main\Voting\Association\UpdateRequest;
use App\Http\Requests\Manage\People\Admins\QueryRequest;
use Src\Auth\Role;
use Src\Voting\Association;
use Src\Voting\Facades\AssociationRepository;

class AssociationsController extends Controller
{
    public function index(QueryRequest $queried)
    {
        $associations = $queried->query()->paginate(20);

        return view('main.voting.associations.list', compact('associations'))->with([
            'filters' => $queried->filters(),
        ]);
    }


    public function create()
    {
        return view('main.voting.associations.create');
    }

    public function store(StoreRequest $request)
    {
        $input['association']['name'] = $request->input('name');
        $input['association']['description'] = $request->input('description');
        $input['association']['status'] = $request->input('status');
        $input['association']['created_by'] = auth()->id();

        $association = AssociationRepository::create($input);

        flash()->success("Association <strong>{$association->name}</strong> is created.");


        return redirect()->route('main.voting.associations.list');
    }

    public function show($id)
    {
        $association = Association::findOrFail($id);
        return view('main.voting.associations.show', compact('association'));
    }

    public function edit($id)
    {
        $association = Association::findOrFail($id);
        return view('main.voting.associations.edit', compact('association'));
    }

    public function update($id, UpdateRequest $request)
    {
        $association = Association::findOrFail($id);

        $input['association']['name'] = $request->input('name');
        $input['association']['description'] = $request->input('description');
        $input['association']['status'] = $request->input('status');
        $input['association']['created_by'] = auth()->id();

        $association = AssociationRepository::update($association, $input);

        flash()->success("Associate <strong>{$association->name}</strong> is updated.");

        return redirect()->route('main.voting.associations.list');
    }

    public function destroy($id)
    {
        $association = Association::findOrFail($id);

        AssociationRepository::delete($association);

        flash()->success("Association <strong>{$association->name}</strong> is deleted.");

        return redirect()->route('main.voting.associations.list');
    }
}
