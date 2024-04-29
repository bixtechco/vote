<?php

namespace Src\Voting\Repositories;

use Throwable;
use Src\Voting\AssociationMember;
use Illuminate\Support\Facades\DB;

class AssociationMemberRepository
{
    /**
     * Create association_member
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
            'association_member.association_id',
            'association_member.user_id',
            'association_member.is_admin',
        ]);

        return DB::transaction(function () use ($data) {
            $associationMember = AssociationMember::create($data['association_member']);

            return $associationMember;
        });
    }

    /**
     * Update association_member
     *
     * @param AssociationMember $associationMember
     *
     * @return AssociationMember
     * @throws \Exception
     * @throws Throwable
     */
    public function update(AssociationMember $associationMember, $input)
    {
        $data = data_only($input, [
            'association_member.association_id',
            'association_member.user_id',
            'association_member.is_admin',
        ]);

        return DB::transaction(function () use ($associationMember, $data) {
            if ( ! empty($data['association_member'])) {
                $associationMember->update($data['association_member']);
            }

            return $associationMember->fresh();
        });
    }

    /**
     * Delete association_member
     *
     * @param AssociationMember $associationMember
     *
     * @return AssociationMember $associationMember
     * @throws \Exception
     * @throws Throwable
     */
    public function delete(AssociationMember $associationMember)
    {
        return DB::transaction(function () use ($associationMember) {
            $associationMember->delete();
            
            return $associationMember;
        });
    }
}
