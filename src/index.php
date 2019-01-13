<?php

require __DIR__ . '/../vendor/autoload.php';

function hprint ($s) {
  echo "<p>" . $s . "</p>";
}

$dburl = "mongodb://" . getenv('dbname') . ":27017";

hprint("[*] connecting to db on " . $dburl);
hprint(" - the db name is passed in as an ENV");

$collection = (new MongoDB\Client($dburl))->example->users;

$result = $collection->insertMany([
  [
    'answer' => '42',
    'color' => 'purple',
    'mad' => 'wire'
  ],
  [
    'elite' => '1337',
    'color' => 'C0L0|2',
    'foobar' => 'f00b4|2',
    'mad' => 'm4d'
  ],
]);

hprint("Inserted " . $result->getInsertedCount() . " document(s)");

hprint("Let's checkout the document with 'mad' -> 'wire' ...");

$doc = $collection->findOne(['mad' => 'wire']);

var_dump($doc);

hprint("That might look better formatted...");

foreach($doc as $key => $value) {
  hprint($key . "-> " . $value);
}