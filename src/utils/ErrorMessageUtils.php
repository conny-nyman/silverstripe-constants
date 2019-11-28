<?php

class ErrorMessageUtils
{
    /**
     * @param string $field
     * @return string
     */
    public static function getFieldMustBeSetError(string $field): string
    {
        return $field . ' must be set.';
    }

    /**
     * @param string $field
     * @return string
     */
    public static function getFieldAlreadyExistsError(string $field): string
    {
        return $field . ' already exists.';
    }
}
