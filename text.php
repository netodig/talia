<?php 
$patter= "/[^.!?\\s][^.!?]*(?:[.!?:](?!['\"„“]?\\s|$)[^.!?]*)*[.!?:]?['\"„“]?(?=\\s|$)/";

$texto='The second little pig and the third little pig went on along the road. Soon they met a man who was carrying some sticks.
"Please will you give me some sticks ?" asked the second little pig. "I want to build a house for myself."
"Yes," said the man. And he gave the second little pig some sticks.
Then the second little pig built himself a house of sticks. It was stronger than the house of straw.
The second little pig was very pleased with his house. He said, "Now the wolf can’t catch me and eat me."
"I shall build a stronger house than yours," said the third little pig.';

$matches=array();

preg_match_all($patter,$texto,$matches);
echo "<pre>";
print_r($matches);
echo "</pre>";

?>