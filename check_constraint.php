<?php
$results = DB::select("SELECT pg_get_constraintdef(c.oid) as def FROM pg_constraint c JOIN pg_class t ON c.conrelid = t.oid WHERE t.relname = 'izins' AND c.contype = 'c'");
foreach ($results as $r) {
    echo $r->def . "\n";
}
