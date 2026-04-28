<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$username = 'Slamet';
$password = 'Slamet222';

$user = User::where('username', $username)->first();
if ($user) {
    echo "ID: {$user->id}\n";
    echo "Username: '{$user->username}'\n";
    echo "Fullname: '{$user->fullname}'\n";
    echo "Position: '{$user->position}'\n";
    echo "Password Piket: '{$user->password_piket}'\n";
    echo "Main PW Match 'Slamet222': " . (Hash::check($password, $user->password) ? 'YES' : 'NO') . "\n";
    if (!empty($user->password_piket)) {
        echo "Piket PW Match 'Slamet222': " . (Hash::check($password, $user->password_piket) ? 'YES' : 'NO') . "\n";
    }
} else {
    echo "User not found.\n";
}
