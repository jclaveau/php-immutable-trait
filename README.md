# Immutable Trait
This trait makes it super easy to turn an instance immutable or mutable.

## Quality
[![Build Status](https://travis-ci.org/jclaveau/php-immutable-trait.png?branch=master)](https://travis-ci.org/jclaveau/php-immutable-trait)
[![codecov](https://codecov.io/gh/jclaveau/php-immutable-trait/branch/master/graph/badge.svg)](https://codecov.io/gh/jclaveau/php-immutable-trait)
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/jclaveau/php-immutable-trait/issues)
[![Viewed](http://hits.dwyl.com/jclaveau/php-immutable-trait.svg)](http://hits.dwyl.com/jclaveau/php-immutable-trait)

## Installation
php-immutable-trait is installable via [Composer](http://getcomposer.org)

    composer require jclaveau/php-immutable-trait


## Usage
```php
class ImmutableObject
{
    use Immutable;
    // use SwitchableMutability; // This traits provides becomesMutable() and becomesImmutable()

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


$instance = new ImmutableObject;
$instance2 = $instance->setProperty('new value');

var_dump( $instance->getProperty() ); => null
var_dump( $instance2->getProperty() ); => 'new value'
```

## TODO
+ Profiles
+ PHP 7
+ Support immutability for private / protected methods? Should the dev handle it?
  Should we provide a simple protected API for it?
