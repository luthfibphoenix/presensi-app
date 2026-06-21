<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::all();
foreach ($users as $user) {
    echo "ID: {$user->id} | USN: '{$user->username}' | Pos: '{$user->position}' | Name: '{$user->fullname}'\n";
}
