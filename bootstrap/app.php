<?php
$app = new Kernel\Application();

$app->single('kernel', Kernel\Kernel::class);

return $app;