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

            $association->associationMembers()->create([
                'user_id' => auth()->id(),
                'is_admin' => true,
            ]);

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

    public function addMember(Association $association, $input)
    {
        $data = data_all($input, [
            'user_id',
            'is_admin',
        ]);

        return DB::transaction(function () use ($association, $data) {
            $association->associationMembers()->create($data);

            return $association;
        });
    }

    public function removeMember(Association $association, $member)
    {
        return DB::transaction(function () use ($association, $member) {
            $association->associationMembers()->where('id', $member->id)->delete();

            return $association;
        });
    }

    public function setAdmin(Association $association, $member)
    {
        return DB::transaction(function () use ($association, $member) {
            $association->associationMembers()->where('user_id', $member->id)->update([
                'is_admin' => true,
            ]);

            return $association;
        });
    }
}
