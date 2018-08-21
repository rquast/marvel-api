<?php

$PUBLIC_KEY = "343972d2b5514521c8be01925d288091";
$PRIVATE_KEY = "8746ec7a2e9557820c3b37db3098a71b57134bb3";
$TS = time();

$hash = md5($TS . $PRIVATE_KEY . $PUBLIC_KEY);

$content = file_get_contents("https://gateway.marvel.com/v1/public/characters?limit=10&offset=20&ts=$TS&apikey=$PUBLIC_KEY&hash=$hash");

echo $content;
