<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('username', 'Slamet')->first();
if ($user) {
    $user->password = Hash::make('Slamet222');
    $user->save();
    echo "Password for 'Slamet' has been reset to 'Slamet222'.\n";
} else {
    echo "User 'Slamet' not found.\n";
}
