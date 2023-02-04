<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

if (count($argv) !== 3) {
	echo "Usage: php bin/add-user.php <username> <password>";
	exit(1);
}

[, $username, $password] = $argv;

$configurator = App\Bootstrap::boot();
$container = $configurator->createContainer();

$userFacade = $container->getByType(\App\Model\UserFacade::class);
try {
	$userFacade->add($username, $password);
} catch (\App\Model\DuplicateNameException $e) {
	echo "User $username already exists.";
	exit(1);
}
 echo "User $username was created successfully.";

