<?php

$date= \Carbon\Carbon::parse($created_at);

?>

{{ $created_at->diffForHuman() }}