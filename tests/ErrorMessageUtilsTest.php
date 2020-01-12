<?php

namespace Conan\DataObjectUtils;

use SilverStripe\Dev\SapphireTest;

class ErrorMessageUtilsTest extends SapphireTest
{
    /** @var string  */
    private $mockField = 'MockField';

    public function testGetFieldMustBeSetError(): void
    {
        $fieldMustBeSetErrorMessage = ErrorMessageUtils::getFieldMustBeSetError($this->mockField);
        $this->assertEquals($this->mockField . ' must be set.', $fieldMustBeSetErrorMessage);
    }

    public function testGetFieldAlreadyExistsError(): void
    {
        $fieldAlreadyExistsErrorMessage = ErrorMessageUtils::getFieldAlreadyExistsError($this->mockField);
        $this->assertEquals($this->mockField . ' already exists.', $fieldAlreadyExistsErrorMessage);
    }
}
