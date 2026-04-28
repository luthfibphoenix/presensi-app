<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('username', 'Slamet')->first();
if ($user && !empty($user->password_piket)) {
    echo "Piket PW Match 'piket123': " . (Hash::check('piket123', $user->password_piket) ? 'YES' : 'NO') . "\n";
    echo "Piket PW Match '123456': " . (Hash::check('123456', $user->password_piket) ? 'YES' : 'NO') . "\n";
}
