# Memoize

[![Downloads this Month](https://img.shields.io/packagist/dm/h4kuna/memoize.svg)](https://packagist.org/packages/h4kuna/memoize)
[![Latest stable](https://img.shields.io/packagist/v/h4kuna/memoize.svg)](https://packagist.org/packages/h4kuna/memoize)

Part of the [h4kuna PHP libraries](https://github.com/h4kuna/library), see the overview of all packages.

A trait that provides an in-memory cache for your classes. It covers the common use case of caching data for the duration of one request. See the example below.

The API is simple, there is one method **memoize**. The first parameter is a unique key (string or array), the second parameter is a callback and the optional third parameter is a TTL (seconds or `DateInterval`). The trait keeps your class clean, without extra properties for cached values.

Install by composer, requires PHP 8.0 or newer.

```bash
composer require h4kuna/memoize
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
	use h4kuna\Memoize\Memoize;

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

A similar trait can be used for static methods.

```php
class Bar {
	use h4kuna\Memoize\MemoizeStatic;

	public static function loadDataFromDatabaseByUser($userId)
	{
		return static::memoize([__METHOD__, $userId], function() use ($userId) {
			return User::fetchUser($userId);
		});
	}
}
```

### Use both traits
This case is unlikely, and both traits have a method with the same name. You can resolve the conflict by an alias.

```php
use h4kuna\Memoize;

class Baz {
	use Memoize\Memoize, Memoize\MemoizeStatic {
		Memoize\Memoize::memoize insteadof Memoize\MemoizeStatic;
		Memoize\MemoizeStatic::memoize as memoizeStatic;
	}

	public function foo(): string
	{
		return $this->memoize(__METHOD__, fn () => 'foo');
	}

	public static function bar(): string
	{
		return static::memoizeStatic(__METHOD__, fn () => 'bar');
	}
}
```

### Disable Memoize in tests

You can disable Memoize for tests in bootstrap.

```php
use h4kuna\Memoize\Helper;
Helper::bypassMemoize();
```
