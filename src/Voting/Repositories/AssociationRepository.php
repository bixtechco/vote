<?php

namespace Src\Voting\Repositories;

use Throwable;
use Src\Voting\Association;
use Illuminate\Support\Facades\DB;

class AssociationRepository
{
    /**
     * Create association
     *
     * @param array $input
     *
     * @return mixed
     * @throws \Exception
     * @throws Throwable
     */

    public function create(array $input)
    {
        $data = data_all($input, [
            'association.name',
            'association.description',
            'association.created_by',
            'association.updated_by',
            'association.status',
        ]);

        return DB::transaction(function () use ($data) {
            $association = Association::create($data['association']);

            return $association;
        });
    }

    /**
     * Update association
     *
     * @param Association $association
     *
     * @return Association
     * @throws \Exception
     * @throws Throwable
     */
    public function update(Association $association, $input)
    {
        $data = data_only($input, [
            'association.name',
            'association.description',
            'association.created_by',
            'association.updated_by',
            'association.status',
        ]);

        return DB::transaction(function () use ($association, $data) {
            if ( ! empty($data['association'])) {
                $association->update($data['association']);
            }

            return $association->fresh();
        });
    }

    /**
     * Delete association
     *
     * @param Association $association
     *
     * @return Association $association
     * @throws \Exception
     * @throws Throwable
     */
    public function delete(Association $association)
    {
        return DB::transaction(function () use ($association) {
            $association->delete();
            
            return $association;
        });
    }
}
