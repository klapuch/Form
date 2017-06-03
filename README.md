# Form
[![Build Status](https://travis-ci.org/klapuch/Form.svg?branch=master)](https://travis-ci.org/klapuch/Form) [![Build status](https://ci.appveyor.com/api/projects/status/3qiwwv0vbi5e71t4?svg=true)](https://ci.appveyor.com/project/facedown/form) [![Coverage Status](https://coveralls.io/repos/github/klapuch/Form/badge.svg?branch=master)](https://coveralls.io/github/klapuch/Form?branch=master)
## Documentation
### Installation
`composer require klapuch/form`
### Usage
#### Form
```php
new Form\RawForm(
	[
		'method' => 'POST',
		'role' => 'form',
		'class' => 'form-horizontal',
		'action' => '/process.php',
		'name' => self::NAME,
	],
	new Form\CsrfInput($this->csrf)
);
```
#### Select with options
```php
new Form\Select(
	new Form\FakeAttributes(['name' => 'fruit']),
	new Form\Option(
		new Form\DependentAttributes(['value' => 'apple'], $this->storage, 'fruit'),
		'Apple',
		new Validation\OneOfRule(['apple', 'berry'])
	),
	new Form\Option(
	new Form\DependentAttributes(['value' => 'berry'], $this->storage, 'fruit'),
	'Berry',
	new Validation\OneOfRule(['apple', 'berry'])
	)
);
```
#### Input with label
```php
new Form\BoundControl(
	new Form\Input(
		new Form\StoredAttributes(
			[
				'type' => 'email',
				'name' => 'email',
				'class' => 'form-control',
				'required' => 'required',
			],
			$this->storage
		),
		new Constraint\EmailRule()
	),
	new Form\LinkedLabel('Email', 'email')
);
```