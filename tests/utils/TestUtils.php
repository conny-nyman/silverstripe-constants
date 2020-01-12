<?php

namespace Conan\DataObjectUtils;

use SilverStripe\Security\Group;
use SilverStripe\Security\Member;

class TestUtils
{
    /**
     * @param string $name
     * @return Group
     * @throws \SilverStripe\ORM\ValidationException
     */
    public static function createGroup($name): Group
    {
        $adminGroup = Group::create();
        $adminGroup->Title = $name . '-title';
        $adminGroup->Description = $name . '-description';
        $adminGroup->Code = $name . '-code';
        $id = $adminGroup->write();

        return Group::get_by_id($id);
    }

    /**
     * @param $name
     * @param null|Group $group
     * @return Member
     * @throws \SilverStripe\ORM\ValidationException
     */
    public static function createMember($name, $group = null): Member
    {
        $member = Member::create();
        $member->FirstName = $name . '-first-name';
        $member->Surname = $name . '-surname';
        $member->Email = $name . '@email.test';
        $member->Password = $name . '-password';
        $id = $member->write();

        if ($group) {
            $member->Groups()->add($group);
        }

        return Member::get_by_id($id);
    }
}
