<?php

use Conan\DataObjectUtils\GroupUtils;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\Group;
use SilverStripe\Security\Member;

class GroupUtilsTest extends SapphireTest
{
    protected $usesDatabase = true;

    public function setUp(): void
    {
        parent::setUp();
        $adminGroup = $this->createGroup('admin-group');
        $authorGroup = $this->createGroup('author-group');
        $viewerGroup = $this->createGroup('viewer-group');

        $this->createMember('admin-user', $adminGroup);
        $this->createMember('author-user', $authorGroup);
        $this->createMember('viewer-user', $viewerGroup);
        $this->createMember('no-group-user');
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

    /**
     * @param string $name
     * @return Group
     * @throws \SilverStripe\ORM\ValidationException
     */
    protected function createGroup($name): Group
    {
        $adminGroup = Group::create();
        $adminGroup->Title = $name . '-title';
        $adminGroup->Description = $name . '-description';
        $adminGroup->Code = $name . '-code';
        $id = $adminGroup->write();

        return Group::get_by_id($id);
    }

    /**
     * @param string $name
     * @param null|Group $group
     * @throws \SilverStripe\ORM\ValidationException
     */
    protected function createMember($name, $group = null): void
    {
        $member = Member::create();
        $member->FirstName = $name . '-first-name';
        $member->Surname = $name . '-surname';
        $member->Email = $name . '@email.test';
        $member->Password = $name . '-password';
        $member->write();

        if ($group) {
            $member->Groups()->add($group);
        }
    }
}
