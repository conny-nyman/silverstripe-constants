<?php

namespace Conan\DataObjectUtils;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\Group;
use SilverStripe\Security\Member;

class GroupUtilsTest extends SapphireTest
{
    /** @var bool */
    protected $usesDatabase = true;

    public function setUp(): void
    {
        parent::setUp();
        $adminGroup = TestUtils::createGroup('admin-group');
        $authorGroup = TestUtils::createGroup('author-group');
        $viewerGroup = TestUtils::createGroup('viewer-group');

        TestUtils::createMember('admin-user', $adminGroup);
        TestUtils::createMember('author-user', $authorGroup);
        TestUtils::createMember('viewer-user', $viewerGroup);
        TestUtils::createMember('no-group-user');
    }

    public function testGetGroupsFromGroupCodes(): void
    {
        $groupCodes = ['admin-group-code', 'viewer-group-code'];
        $groups = GroupUtils::getGroupsFromGroupCodes($groupCodes);
        $this->assertEquals(2, $groups->count());
    }

    public function testIsMemberInGroups(): void
    {
        $groups = Group::get();

        /** @var Member $adminUser */
        $adminUser = Member::get()->find('Email', 'admin@email.test');
        $adminUserInAGroup = GroupUtils::isMemberInGroups($groups, $adminUser);

        /** @var Member $noGroupUser */
        $noGroupUser = Member::get()->find('Email', 'no-group-user@email.test');
        $noGroupUserInAGroup = GroupUtils::isMemberInGroups(Group::get(), $noGroupUser);

        $this->assertEquals(true, $adminUserInAGroup);
        $this->assertEquals(false, $noGroupUserInAGroup);
    }
}
