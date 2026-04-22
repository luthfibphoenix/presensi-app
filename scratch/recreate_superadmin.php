<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

User::where('username', 'luthfi')->delete();
$user = User::create([
    'fullname' => 'Luthfi Bachtiar Riyanto',
    'username' => 'luthfi',
    'password' => bcrypt('password123'),
    'position' => 'Super Administrator',
    'nip' => '000000',
    'pangkat' => '-',
    'jabatan' => 'Super Administrator',
    'is_wali' => false,
]);

if ($user->exists) {
    echo "SUCCESS: User created with ID: " . $user->id . "\n";
} else {
    echo "FAILURE: User not saved.\n";
}
