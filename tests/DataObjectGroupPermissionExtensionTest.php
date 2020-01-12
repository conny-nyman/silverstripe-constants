<?php

namespace Conan\DataObjectUtils;

use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\Member;

class DataObjectGroupPermissionExtensionTest extends SapphireTest
{
    /** @var bool */
    protected $usesDatabase = true;
    /** @var Member */
    protected $adminUser;
    /** @var Member */
    protected $authorUser;
    /** @var Member */
    protected $viewerUser;
    /** @var Member */
    protected $noGroupUser;
    /** @var DataObjectGroupPermissionExtension */
    protected $permissionExtension;

    public function setUp(): void
    {
        parent::setUp();
        $this->setupMembersAndGroups();
        $this->setupGroupPermissions();
        $this->permissionExtension = new DataObjectGroupPermissionExtension();
    }

    private function setupMembersAndGroups(): void
    {
        $adminGroup = TestUtils::createGroup('admin-group');
        $authorGroup = TestUtils::createGroup('author-group');
        $viewerGroup = TestUtils::createGroup('viewer-group');

        $this->adminUser = TestUtils::createMember('admin-user', $adminGroup);
        $this->authorUser = TestUtils::createMember('author-user', $authorGroup);
        $this->viewerUser = TestUtils::createMember('viewer-user', $viewerGroup);
        $this->noGroupUser = TestUtils::createMember('no-group-user');
    }

    private function setupGroupPermissions(): void
    {
        Config::modify()->update(DataObjectGroupPermissionExtension::class, DataObjectGroupPermissionExtension::CAN_VIEW_GROUP_CODES, [
            'admin-group-code',
            'author-group-code',
            'viewer-group-code',
        ]);

        Config::modify()->update(DataObjectGroupPermissionExtension::class, DataObjectGroupPermissionExtension::CAN_EDIT_GROUP_CODES, [
            'admin-group-code',
            'author-group-code',
        ]);

        Config::modify()->update(DataObjectGroupPermissionExtension::class, DataObjectGroupPermissionExtension::CAN_CREATE_GROUP_CODES, [
            'admin-group-code',
            'author-group-code',
        ]);

        Config::modify()->update(DataObjectGroupPermissionExtension::class, DataObjectGroupPermissionExtension::CAN_DELETE_GROUP_CODES, [
            'admin-group-code',
        ]);
    }

    public function testCanView(): void
    {
        $this->assertEquals(true, $this->permissionExtension->canView($this->adminUser));
        $this->assertEquals(true, $this->permissionExtension->canView($this->authorUser));
        $this->assertEquals(true, $this->permissionExtension->canView($this->viewerUser));
        $this->assertEquals(false, $this->permissionExtension->canView($this->noGroupUser));
    }

    public function testCanEdit(): void
    {
        $this->assertEquals(true, $this->permissionExtension->canEdit($this->adminUser));
        $this->assertEquals(true, $this->permissionExtension->canEdit($this->authorUser));
        $this->assertEquals(false, $this->permissionExtension->canEdit($this->viewerUser));
        $this->assertEquals(false, $this->permissionExtension->canView($this->noGroupUser));
    }

    public function testCanCreate(): void
    {
        $this->assertEquals(true, $this->permissionExtension->canCreate($this->adminUser));
        $this->assertEquals(true, $this->permissionExtension->canCreate($this->authorUser));
        $this->assertEquals(false, $this->permissionExtension->canCreate($this->viewerUser));
        $this->assertEquals(false, $this->permissionExtension->canView($this->noGroupUser));
    }

    public function testCanDelete(): void
    {
        $this->assertEquals(true, $this->permissionExtension->canDelete($this->adminUser));
        $this->assertEquals(false, $this->permissionExtension->canDelete($this->authorUser));
        $this->assertEquals(false, $this->permissionExtension->canDelete($this->viewerUser));
        $this->assertEquals(false, $this->permissionExtension->canView($this->noGroupUser));
    }
}
