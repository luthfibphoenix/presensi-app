















































































<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$username = 'Slamet';
$password = 'Slamet333';

$user = User::where('username', $username)->first();

echo "--- HASIL PENGECEKAN ---\n";
if ($user) {
    echo "User ditemukan!\n";
    echo "Username di DB: " . $user->username . "\n";
    echo "Fullname: " . $user->fullname . "\n";
    echo "Position: " . $user->position . "\n";
    echo "Cek Password ($password): " . (Hash::check($password, $user->password) ? "COCOK" : "TIDAK COCOK") . "\n";
} else {
    echo "User '$username' TIDAK DITEMUKAN di database.\n";
    $allUser = User::take(5)->pluck('username')->toArray();
    echo "Contoh username yang ada: " . implode(', ', $allUser) . "\n";
}
