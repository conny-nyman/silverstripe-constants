<?php

namespace Conan\DataObjectUtils;

class MemberFieldConstants extends DataObjectFieldConstants
{
    const FIRST_NAME = 'FirstName';
    const SURNAME = 'Surname';
    const EMAIL = 'Email';
    const TEMP_ID_HASH = 'TempIDHash';
    const TEMP_ID_EXPIRED = 'TempIDExpired';
    const PASSWORD = 'Password';
    const AUTO_LOGIN_HASH = 'AutoLoginHash';
    const AUTO_LOGIN_EXPIRED = 'AutoLoginExpired';
    const PASSWORD_ENCRYPTION = 'PasswordEncryption';
    const SALT = 'Salt';
    const PASSWORD_EXPIRY = 'PasswordExpiry';
    const LOCKED_OUT_UNTIL = 'LockedOutUntil';
    const LOCALE = 'Locale';
    const FAILED_LOGIN_COUNT = 'FailedLoginCount';
}
