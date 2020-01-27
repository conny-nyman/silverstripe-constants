<?php

namespace Conan\DataObjectUtils;

use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\DataExtension;

class DataObjectGroupPermissionExtension extends DataExtension
{
    const CAN_VIEW_GROUP_CODES = 'can_view_group_codes';
    const CAN_EDIT_GROUP_CODES = 'can_edit_group_codes';
    const CAN_CREATE_GROUP_CODES = 'can_create_group_codes';
    const CAN_DELETE_GROUP_CODES = 'can_delete_group_codes';

    /**
     * @param null $member
     * @return bool|null
     */
    public function canView($member = null): ?bool
    {
        $can_view_group_codes = self::getConfigGroupCodes(self::CAN_VIEW_GROUP_CODES);
        if (!$can_view_group_codes) {
            return null;
        }
        return self::memberHasAccess($can_view_group_codes, $member);
    }

    /**
     * @param null $member
     * @return bool|null
     */
    public function canEdit($member = null): ?bool
    {
        $can_edit_group_codes = self::getConfigGroupCodes(self::CAN_EDIT_GROUP_CODES);
        if (!$can_edit_group_codes) {
            return null;
        }
        return self::memberHasAccess($can_edit_group_codes, $member);
    }

    /**
     * @param null $member
     * @return bool|null
     */
    public function canCreate($member = null): ?bool
    {
        $can_create_group_codes = self::getConfigGroupCodes(self::CAN_CREATE_GROUP_CODES);
        if (!$can_create_group_codes) {
            return null;
        }
        return self::memberHasAccess($can_create_group_codes, $member);
    }

    /**
     * @param null $member
     * @return bool|null
     */
    public function canDelete($member = null): ?bool
    {
        $can_delete_group_codes = self::getConfigGroupCodes(self::CAN_DELETE_GROUP_CODES);
        if (!$can_delete_group_codes) {
            return null;
        }
        return self::memberHasAccess($can_delete_group_codes, $member);
    }

    /**
     * @param string $groupCodeConfigKey
     * @return array
     */
    protected static function getConfigGroupCodes(string $groupCodeConfigKey)
    {
        return Config::inst()->get(__CLASS__, $groupCodeConfigKey) ?: null;
    }

    /**
     * @param $groupCodes
     * @param null $member
     * @return bool
     */
    protected static function memberHasAccess($groupCodes, $member = null): bool
    {
        $groups = GroupUtils::getGroupsFromGroupCodes($groupCodes);
        return GroupUtils::isMemberInGroups($groups, $member);
    }
}
