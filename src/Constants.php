<?php

namespace Conan\DataObjectUtils;

class DBConstants
{
    const BOOLEAN = 'Boolean';
    const CURRENCY = 'Currency';
    const DATE = 'Date';
    const DECIMAL = 'Decimal';
    const HTML_TEXT = 'HTMLText';
    const HTML_VARCHAR = 'HTMLVarchar';
    const INT = 'Int';
    const PERCENTAGE = 'Percentage';
    const DATETIME = 'Datetime';
    const TEXT = 'Text';
    const TIME = 'Time';
    const VARCHAR = 'Varchar';
}

class FormFieldConstants
{
    const TITLE = 'Title';
    const DESCRIPTION = 'Description';
}

class SearchFilterConstants
{
    const STARTS_WITH_FILTER = 'StartsWithFilter';
    const ENDS_WITH_FILTER = 'EndsWithFilter';
    const PARTIAL_MATCH_FILTER = 'PartialMatchFilter';
    const GREATER_THAN_FILTER = 'GreaterThanFilter';
    const GREATER_THAN_OR_EQUAL_FILTER = 'GreaterThanOrEqualFilter';
    const LESS_THAN_FILTER = 'LessThanFilter';
    const LESS_THAN_OR_EQUAL_FILTER = 'LessThanOrEqualFilter';
}
