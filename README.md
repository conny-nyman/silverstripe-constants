# silverstripe-data-object-utils
Silverstripe CMS 4 constants and CMS field util functions.

Keep your Silverstripe CMS 4 code DRY!

## Constants
- Data types

## CMS fields util functions
- Translate title and description on form fields using the same naming convention

## Example usage
```

namespace The\Namespace;

use Conan\DataObjectUtils\DBConstants;
use Conan\DataObjectUtils\CMSFieldUtils;
use SilverStripe\ORM\DataObject;

class MyClass extends DataObject 
{
    const MY_STRING_FIELD = 'MyStringField';
    const MY_INT_FIELD = 'MyIntField';

    private static $db = [
        self::MY_STRING_FIELD => DBConstants::VARCHAR,    
        self::MY_INT_FIELD => DBConstants::INT,    
    ];

    public function getCMSFields() 
    {
        $fields = parent::getCMSFields();
        $myStringField = $fields->fieldByName('Root.Main.' . self::MY_STRING_FIELD);
        CMSFieldUtils::setTitle($myStringField, 'My title');
        CMSFieldUtils::setDescription($myStringField, 'My description');
    
        // Or for both title and description you can use this
        // CMSFieldUtils::setTitleAndDescription($myStringField, 'My title', 'My description');
    }
}
```

The field can then be translated like this:

```
en:
  The\Namespace\MyClass:
    MyStringField.Title: 'Translated title'
    MyStringField.Description: 'Translated description'
```

By default the namespaced class name is used, but it is possible to pass a custom value as the caller class.
e.g. `CMSFieldUtils::setTitle($myStringField, 'My title', 'MyModule');` and then translate it like this:
```
en:
  MyModule:
    MyStringField.Title: 'Translated title'
    MyStringField.Description: 'Translated description'
```

# TODO:
- Add useful wrappers for data type data fields, e.g. custom `Datetime` field which could take a default datetime value in the constructor, which would be used during column creation.
