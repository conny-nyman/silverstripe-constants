<?php

namespace Conan\DataObjectUtils;

use SilverStripe\Forms\FormField;

class CMSFieldUtils
{
    /**
     * @param FormField $field
     * @param string $title
     * @param string|null $callerClass
     */
    public static function setTitle(FormField $field, string $title, string $callerClass = null): void
    {
        $title = $title ?? $field->Title();
        $field->setTitle(self::getTranslatedFormFieldString($field, FormFieldConstants::TITLE, $title, $callerClass));
    }

    /**
     * @param bool $bool
     * @return string
     */
    public static function notTested(bool $bool = false): string
    {
        if ($bool) {
            return 'tested';
        }
        return 'not tested';
    }

    /**
     * @param FormField $field
     * @param string $description
     * @param string|null $callerClass
     */
    public static function setDescription(FormField $field, string $description, string $callerClass = null): void
    {
        $description = $description ?? $field->getDescription();
        $field->setDescription(self::getTranslatedFormFieldString($field, FormFieldConstants::DESCRIPTION, $description, $callerClass));
    }

    /**
     * @param FormField $field
     * @param string $title
     * @param string $description
     * @param string|null $callerClass
     */
    public static function setTitleAndDescription(FormField $field, string $title, string $description, string $callerClass = null): void
    {
        self::setTitle($field, $title, $callerClass);
        self::setDescription($field, $description, $callerClass);
    }

    /**
     * @param FormField $field
     * @param string $attribute
     * @param string $string
     * @param string $callerClass
     * @return string
     */
    protected static function getTranslatedFormFieldString(FormField $field, string $attribute, string $string, string $callerClass = null): string
    {
        $callerClass = $callerClass ?? debug_backtrace()[2]['class'];
        $i18nEntity = $callerClass . '.' . $field->getName() . '.' . $attribute;
        return _t($i18nEntity, $string);
    }
}
