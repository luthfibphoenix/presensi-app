<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

try {
    $user = User::where('username', 'luthfi')->first();
    if ($user) {
        echo "User already exists with ID: " . $user->id . "\n";
    } else {
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
        echo "User created with ID: " . $user->id . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
