# Xparse

A small lib, to parse XML or HTML details with XPath expressions into a PHP array structure.

## Installation

```sh
$ composer require dadyday/xparse
```

## Usage

We create the scheme first (maybe in a DI container), and parse the document within our business logic.

```php
<?php
use Xparse\Parser;

$xml = 
'<?xml version="1.0">
<root>
    <el attr="an attrib">
        the <i>1.</i> content
    </el>
    <el>
        <b>2.</b> content
    </el>
    <el attr="another attrib">
        more content
    </el>
</root>';

# every el in a assoc array
$oValue = Value::map('//el', 
    # integer key of map with a default
    Value::int('.//i|b', 0), 
    # value of map is a struct of values
    Value::struct([
        # a attribute with a handler function
        'attr' => Value::str('@attr', function($val) {
            # val is null if not found
            return $val ?? 'not found';
        }),
        # all textnodes in the current context 
        'text' => './text()', # short for Value::str(...)
        # returns the existence as a boolean
        'last' => Value::not('following-sibling::el'),
    ])
);
$oParser = new Parser($oValue);
$aList = $oParser->parseXml($xml);
$aList = [ // map for every el
    // key is first i-content as integer
    1 => [ // struct for first el
        'attr' => 'an attrib', // attr of first el
        'text' => 'the 1. content' // text content
        'last' => false, // there is a following el
    ],
    // key from b-content
    2 => [ // secound el
        'attr' => null, // there is no attrib
        'text' => '2. content' 
        'last' => false,
    ],
    // key is the default 0
    0 => [ // third el
        'attr' => 'another attrib',
        'text' => 'more content' 
        'last' => true, // no following
    ],
];
```
