<?php

namespace Conan\DataObjectUtils;

use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\Member;

class DataObjectGroupPermissionExtensionTest extends SapphireTest
{
    /** @var string */
    private const EXPECT = 'expect';
    /** @var string */
    private const PERMISSION_METHOD = 'permissionMethod';
    /** @var string */
    private const USER = 'user';

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

    public function testCanView(): void
    {
        /** @var string $canView */
        $canView = 'canView';

        $this->assertPermission([
            [self::EXPECT => true, self::PERMISSION_METHOD => $canView, self::USER => $this->adminUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canView, self::USER => $this->authorUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canView, self::USER => $this->viewerUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canView, self::USER => $this->noGroupUser],
        ]);

        self::setupAllowAnyPermissions();

        $this->assertPermission([
            [self::EXPECT => true, self::PERMISSION_METHOD => $canView, self::USER => $this->adminUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canView, self::USER => $this->authorUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canView, self::USER => $this->viewerUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canView, self::USER => $this->noGroupUser],
        ]);

        self::setupAllowNonePermissions();

        $this->assertPermission([
            [self::EXPECT => false, self::PERMISSION_METHOD => $canView, self::USER => $this->adminUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canView, self::USER => $this->authorUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canView, self::USER => $this->viewerUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canView, self::USER => $this->noGroupUser],
        ]);
    }

    public function testCanEdit(): void
    {
        /** @var string $canEdit */
        $canEdit = 'canEdit';

        $this->assertPermission([
            [self::EXPECT => true, self::PERMISSION_METHOD => $canEdit, self::USER => $this->adminUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canEdit, self::USER => $this->authorUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canEdit, self::USER => $this->viewerUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canEdit, self::USER => $this->noGroupUser],
        ]);

        self::setupAllowAnyPermissions();

        $this->assertPermission([
            [self::EXPECT => true, self::PERMISSION_METHOD => $canEdit, self::USER => $this->adminUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canEdit, self::USER => $this->authorUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canEdit, self::USER => $this->viewerUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canEdit, self::USER => $this->noGroupUser],
        ]);

        self::setupAllowNonePermissions();

        $this->assertPermission([
            [self::EXPECT => false, self::PERMISSION_METHOD => $canEdit, self::USER => $this->adminUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canEdit, self::USER => $this->authorUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canEdit, self::USER => $this->viewerUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canEdit, self::USER => $this->noGroupUser],
        ]);
    }

    public function testCanCreate(): void
    {
        /** @var string $canCreate */
        $canCreate = 'canCreate';

        $this->assertPermission([
            [self::EXPECT => true, self::PERMISSION_METHOD => $canCreate, self::USER => $this->adminUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canCreate, self::USER => $this->authorUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canCreate, self::USER => $this->viewerUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canCreate, self::USER => $this->noGroupUser],
        ]);

        self::setupAllowAnyPermissions();

        $this->assertPermission([
            [self::EXPECT => true, self::PERMISSION_METHOD => $canCreate, self::USER => $this->adminUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canCreate, self::USER => $this->authorUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canCreate, self::USER => $this->viewerUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canCreate, self::USER => $this->noGroupUser],
        ]);

        self::setupAllowNonePermissions();

        $this->assertPermission([
            [self::EXPECT => false, self::PERMISSION_METHOD => $canCreate, self::USER => $this->adminUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canCreate, self::USER => $this->authorUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canCreate, self::USER => $this->viewerUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canCreate, self::USER => $this->noGroupUser],
        ]);
    }

    public function testCanDelete(): void
    {
        /** @var string $canCreate */
        $canDelete = 'canDelete';

        $this->assertPermission([
            [self::EXPECT => true, self::PERMISSION_METHOD => $canDelete, self::USER => $this->adminUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canDelete, self::USER => $this->authorUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canDelete, self::USER => $this->viewerUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canDelete, self::USER => $this->noGroupUser],
        ]);

        self::setupAllowAnyPermissions();

        $this->assertPermission([
            [self::EXPECT => true, self::PERMISSION_METHOD => $canDelete, self::USER => $this->adminUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canDelete, self::USER => $this->authorUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canDelete, self::USER => $this->viewerUser],
            [self::EXPECT => true, self::PERMISSION_METHOD => $canDelete, self::USER => $this->noGroupUser],
        ]);

        self::setupAllowNonePermissions();

        $this->assertPermission([
            [self::EXPECT => false, self::PERMISSION_METHOD => $canDelete, self::USER => $this->adminUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canDelete, self::USER => $this->authorUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canDelete, self::USER => $this->viewerUser],
            [self::EXPECT => false, self::PERMISSION_METHOD => $canDelete, self::USER => $this->noGroupUser],
        ]);
    }

    public function testAllowAny(): void
    {
        $this->assertEquals(true, DataObjectGroupPermissionExtension::allowAny([true]));
        $this->assertEquals(false, DataObjectGroupPermissionExtension::allowAny([false]));

        // Other group codes should not affect the allow "any" group code
        $this->assertEquals(true, DataObjectGroupPermissionExtension::allowAny(['group-code', true]));
        $this->assertEquals(false, DataObjectGroupPermissionExtension::allowAny(['group-code', false]));
    }

    public function testAllowNone(): void
    {
        $this->assertEquals(true, DataObjectGroupPermissionExtension::allowNone([false]));
        $this->assertEquals(false, DataObjectGroupPermissionExtension::allowNone([true]));

        // Other group codes should not affect the allow "none" group code
        $this->assertEquals(true, DataObjectGroupPermissionExtension::allowNone(['group-code', false]));
        $this->assertEquals(false, DataObjectGroupPermissionExtension::allowNone(['group-code', true]));
    }

    /**
     * @param array(
     *  'expect' => bool,
     *  'permissionMethod' => string,
     *  'user' => string,
     * ) $asserts
     */
    protected function assertPermission($asserts): void
    {
        foreach ($asserts as $assert) {
            $this->assertEquals(
                $assert[self::EXPECT],
                $this->permissionExtension->{$assert[self::PERMISSION_METHOD]}($assert[self::USER])
            );
        }
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

    protected function setupGroupPermissions(): void
    {
        $canViewGroupCodes = [
            'admin-group-code',
            'author-group-code',
            'viewer-group-code',
        ];

        $canEditGroupCodes = [
            'admin-group-code',
            'author-group-code',
        ];

        $canCreateGroupCodes = [
            'admin-group-code',
            'author-group-code',
        ];

        $canDeleteGroupCodes = [
            'admin-group-code',
        ];

        self::setGroupPermissionsToConfig(
            $canViewGroupCodes,
            $canEditGroupCodes,
            $canCreateGroupCodes,
            $canDeleteGroupCodes
        );
    }

    protected function setupAllowAnyPermissions(): void
    {
        self::setGroupPermissionsToConfig(
            [true],
            [true],
            [true],
            [true]
        );
    }

    protected static function setupAllowNonePermissions(): void
    {
        self::setGroupPermissionsToConfig(
            [false],
            [false],
            [false],
            [false]
        );
    }

    /**
     * @param array $canViewGroups
     * @param array $canEditGroups
     * @param array $canCreateGroups
     * @param array $canDeleteGroups
     */
    protected static function setGroupPermissionsToConfig($canViewGroups, $canEditGroups, $canCreateGroups, $canDeleteGroups): void
    {
        Config::modify()->update(DataObjectGroupPermissionExtension::class, DataObjectGroupPermissionExtension::CAN_VIEW_GROUP_CODES, $canViewGroups);
        Config::modify()->update(DataObjectGroupPermissionExtension::class, DataObjectGroupPermissionExtension::CAN_EDIT_GROUP_CODES, $canEditGroups);
        Config::modify()->update(DataObjectGroupPermissionExtension::class, DataObjectGroupPermissionExtension::CAN_CREATE_GROUP_CODES, $canCreateGroups);
        Config::modify()->update(DataObjectGroupPermissionExtension::class, DataObjectGroupPermissionExtension::CAN_DELETE_GROUP_CODES, $canDeleteGroups);
    }
}
