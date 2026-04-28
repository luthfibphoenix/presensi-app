<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('username', 'Slamet')->first();
if ($user) {
    $user->position = 'Guru Pendidikan Pancasila';
    $user->save();
    echo "Position for 'Slamet' has been changed to 'Guru Pendidikan Pancasila' in the database.\n";
} else {
    echo "User 'Slamet' not found.\n";
}
