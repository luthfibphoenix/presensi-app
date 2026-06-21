<?php
try { 
    App\Models\QrSession::create([
        'jadwal_id' => 1, 
        'tanggal' => date('Y-m-d'), 
        'token' => 'abc', 
        'expired_at' => \Carbon\Carbon::now()->addMinutes(15)
    ]); 
    echo 'SUCCESS'; 
} catch (\Exception $e) { 
    echo $e->getMessage(); 
}
