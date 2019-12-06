<?php

namespace Conan\DataObjectUtils;

use SilverStripe\ORM\DataList;
use SilverStripe\ORM\SS_List;
use SilverStripe\Security\Group;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

class GroupUtils
{
    /**
     * @param $groupCodes
     * @return DataList
     */
    public static function getGroupsFromGroupCodes($groupCodes)
    {
        return Group::get()->filter(GroupFieldConstants::CODE, $groupCodes);
    }

    /**
     * @param array|SS_List $groups
     * @param Member|null $member
     * @return bool
     */
    public static function isMemberInGroups($groups, Member $member = null): bool
    {
        $member = $member ?: Security::getCurrentUser();
        if ($member && $member->inGroups($groups)) {
            return true;
        }
        return false;
    }
}
