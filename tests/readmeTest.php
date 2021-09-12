<?php
require_once __DIR__.'/cfg.php';

use Tester\Assert as Is;
use Xparse\Parser;
use Xparse\Value;

$xml = 
'<?xml version="1.0"?>
<root>
    <el id="a" attr="an attrib">
        the <b>important</b> and <i>1st</i> content
    </el>
    <el id="b">
        <b>2nd</b> content
    </el>
    <el id="c" attr="another attrib">
        3rd content
    </el>
</root>';

# every el in a assoc array
$oValue = Value::map('//el', 
    # integer key of map with a default
    Value::int('i|b', 'none'), 
    # value of map is a struct of values
    [ # short for Value::struct([...])
        # a attribute with a handler function
        'attr' => Value::str('@attr', function($val) {
            # val is null if not found
            return ($val ?? 'not') . ' found';
        }),
        # all textnodes in the current context 
        'text' => '.', # short for Value::str('...')
        # returns the existence as a boolean
        'next' => Value::bool('following-sibling::el'),
        # return a list of 2. arg within each finding of the first
        'prev' => Value::list('preceding-sibling::el', '@id'),
    ]
);
$oParser = new Parser($oValue);
$aList = $oParser->parseXml($xml);
dump($aList);
Is::equal($aList, [ // map for every el
    // key is first i-content as integer
    1 => [ // struct for first el
        'attr' => 'an attrib found', // attr of first el 
        'text' => 'the important and 1st content', // text content
        'next' => true, // there are following el's
        'prev' => [], // no previous el
    ],
    // key from b-content
    2 => [ // secound el
        'attr' => 'not found', // there is no attrib
        'text' => '2nd content', 
        'next' => true,
        'prev' => ['a'], // one el before
    ],
    // key is the default 'none'
    'none' => [ // third el
        'attr' => 'another attrib found',
        'text' => '3rd content', 
        'next' => false, // no el behind
        'prev' => ['a', 'b'], // two el's before
    ],
]);
