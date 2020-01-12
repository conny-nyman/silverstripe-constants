<?php

namespace Conan\DataObjectUtils;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FormField;

class CMSFieldUtilsTest extends SapphireTest
{
    /** @var FormField */
    private $mockFormField;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockFormField = new FormField('mock', 'initial title', 'initial value');
    }

    public function testSetTitle(): void
    {
        $updatedTitle = 'updated title';
        CMSFieldUtils::setTitle($this->mockFormField, $updatedTitle);

        $this->assertEquals($updatedTitle, $this->mockFormField->Title());
    }

    public function testSetDescription(): void
    {
        $updatedDescription = 'updated description';
        CMSFieldUtils::setDescription($this->mockFormField, $updatedDescription);

        $this->assertEquals($updatedDescription, $this->mockFormField->getDescription());
    }

    public function testSetTitleAndDescription(): void
    {
        $updatedTitle = 'updated title 2';
        $updatedDescription = 'updated description 2';
        CMSFieldUtils::setTitleAndDescription($this->mockFormField, $updatedTitle, $updatedDescription);

        $this->assertEquals($updatedTitle, $this->mockFormField->Title());
        $this->assertEquals($updatedDescription, $this->mockFormField->getDescription());
    }
}
