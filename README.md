# Memoize

[![Downloads this Month](https://img.shields.io/packagist/dm/h4kuna/memoize.svg)](https://packagist.org/packages/h4kuna/memoize)
[![Latest stable](https://img.shields.io/packagist/v/h4kuna/memoize.svg)](https://packagist.org/packages/h4kuna/memoize)

Is one trait whose provide cache to memory for classes. This is abstract standard use case how cache data for one request. Example is below.

Api is easy where is one method **memoize** where first parameter is unique key string or array and second parameter is callback. This trait clear class.

Install by composer

```
$ composer require h4kuna/memoize
```

### Standard use case
```php
<?php

class Foo
{

	private $dataFromDatabase;

	private $users = [];


	public function loadDataFromDatabase()
	{
		if ($this->dataFromDatabase === null) {
			$this->dataFromDatabase = $this->repository->fetchAnyData();
		}
		return $this->dataFromDatabase;
	}


	public function loadDataFromDatabaseByUser($userId)
	{
		if (isset($this->users[$userId]) === false) {
			$this->users[$userId] = $this->repository->fetchUser($userId);
		}
		return $this->users[$userId];
	}

}
```

### Use Memoize

```php
<?php

class Foo
{
	use h4kuna\Memoize\MemoryStorage;

	public function loadDataFromDatabase()
	{
		return $this->memoize(__METHOD__, function() {
			return $this->repository->fetchAnyData();
		});
	}


	public function loadDataFromDatabaseByUser($userId)
	{
		return $this->memoize([__METHOD__, $userId], function() use ($userId) {
			return $this->repository->fetchUser($userId);
		});
	}

}

```

### Static use case

The similar class can be used for static class. 

```php
class Bar {
	use h4kuna\Memoize\MemoryStorageStatic

	public static function loadDataFromDatabaseByUser($userId)
	{
		return static::memoize([__METHOD__, $userId], function() use ($userId) {
			return User::fetchUser($userId);
		});
	}
}
```

### Use both traits
This case is unlikely, so the names are the same. You can resolve by alias.

```php
class Baz {
	use Memoize\MemoryStorage, Memoize\MemoryStorageStatic {
		Memoize\MemoryStorage::memoize insteadof Memoize\MemoryStorageStatic;
		Memoize\MemoryStorageStatic::memoize as memoizeStatic;
	}
	
	public function foo(): 
	{
		return $this->memoize();
	}
	
	public static function bar(): 
	{
		return static::memoizeStatic();
	}
}
```

### Disable Memoize in tests

You can disable Memoize for tests in bootstrap.

```php
use h4kuna\Memoize\Helper;
Helper::bypassMemoize();
```
