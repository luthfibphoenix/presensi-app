<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

User::where('username', 'luthfi')->delete();

// Get the next ID manually just in case
$nextId = DB::table('users')->max('id') + 1;
if ($nextId < 1000) $nextId = 1001; // Avoid collisions with existing users

$user = new User();
$user->id = $nextId; // Force ID
$user->fullname = 'Luthfi Bachtiar Riyanto';
$user->username = 'luthfi';
$user->password = bcrypt('password123');
$user->position = 'Super Administrator';
$user->nip = '000000';
$user->pangkat = '-';
$user->jabatan = 'Super Administrator';
$user->is_wali = false;
$user->save();

if ($user->exists) {
    echo "SUCCESS: User created with ID: " . $user->id . "\n";
} else {
    echo "FAILURE: User not saved.\n";
}
