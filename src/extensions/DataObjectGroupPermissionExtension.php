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
    const DEFAULT_GROUP_CODES = [GroupCodeConstants::ADMINISTRATORS_GROUP_CODE, GroupCodeConstants::CONTENT_AUTHORS_GROUP_CODE];

    /**
     * @param null $member
     * @return bool
     */
    public function canView($member = null): bool
    {
        $can_view_group_codes = self::getConfigGroupCodesOrDefault(self::CAN_VIEW_GROUP_CODES);
        return self::memberHasAccess($can_view_group_codes, $member);
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canEdit($member = null): bool
    {
        $can_edit_group_codes = self::getConfigGroupCodesOrDefault(self::CAN_EDIT_GROUP_CODES);
        return self::memberHasAccess($can_edit_group_codes, $member);
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canCreate($member = null): bool
    {
        $can_create_group_codes = self::getConfigGroupCodesOrDefault(self::CAN_CREATE_GROUP_CODES);
        return self::memberHasAccess($can_create_group_codes, $member);
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canDelete($member = null): bool
    {
        $can_delete_group_codes = self::getConfigGroupCodesOrDefault(self::CAN_DELETE_GROUP_CODES);
        return self::memberHasAccess($can_delete_group_codes, $member);
    }

    /**
     * @param string $groupCodeConfigKey
     * @return array
     */
    protected static function getConfigGroupCodesOrDefault(string $groupCodeConfigKey)
    {
        return Config::inst()->get(__CLASS__, $groupCodeConfigKey) ?: self::DEFAULT_GROUP_CODES;
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
