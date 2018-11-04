# Immutable trait
This trait makes it super easy to turn an instance immutable or mutable.

## Quality
--------------
[![Build Status](https://travis-ci.org/jclaveau/php-logical-filter.png?branch=master)](https://travis-ci.org/jclaveau/php-logical-filter)
[![codecov](https://codecov.io/gh/jclaveau/php-logical-filter/branch/master/graph/badge.svg)](https://codecov.io/gh/jclaveau/php-logical-filter)
[![Maintainability](https://api.codeclimate.com/v1/badges/eb85279bcfb224b7af1c/maintainability)](https://codeclimate.com/github/jclaveau/php-logical-filter/maintainability)
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/jclaveau/php-logical-filter/issues)
[![Viewed](http://hits.dwyl.com/jclaveau/php-logical-filter.svg)](http://hits.dwyl.com/jclaveau/php-logical-filter)


## Usage
```php
class ImmutableObject
{
    use Immutable;

    protected $property;

    public function setProperty($value)
    {
        // Just add these lines at the really beginning of methods supporting
        // immutability (setters mostly)
        if ($this->callOnCloneIfImmutable($result))
            return $result;

        // Do wathever you want in your method returning whatever you want else
        $this->property = $value;
        return $this;
    }

    public function getProperty()
    {
        return $this->property;
    }
}


$instance = (new ImmutableObject)->setImmutable();
$instance2 = $instance->setProperty('new value');

var_dump( $instance->getProperty() ); => null
var_dump( $instance2->getProperty() ); => 'new value'
```
