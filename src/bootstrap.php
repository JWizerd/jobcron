<?php

require __DIR__ . '../../vendor/autoload.php';

use MongoDB\Client as Connection;

$dbUrl = sprintf(
  "mongodb://%s:27017",
  getenv('dbname')
);

$connection = new Connection($dbUrl);

print_r($connection);

// print_r($connection);

// $collection = (new MongoDB\Client($dburl))->example->users;

// $result = $collection->insertMany([
//   [
//     'answer' => '42',
//     'color' => 'purple',
//     'mad' => 'wire'
//   ],
//   [
//     'elite' => '1337',
//     'color' => 'C0L0|2',
//     'foobar' => 'f00b4|2',
//     'mad' => 'm4d'
//   ],
// ]);

// hprint("Inserted " . $result->getInsertedCount() . " document(s)");

// hprint("Let's checkout the document with 'mad' -> 'wire' ...");

// $doc = $collection->findOne(['mad' => 'wire']);

// var_dump($doc);

// hprint("That might look better formatted...");

// foreach($doc as $key => $value) {
//   hprint($key . "-> " . $value);
// }



