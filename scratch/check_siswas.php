<?php
$cols = DB::select("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = 'siswas' ORDER BY ordinal_position");
foreach ($cols as $c) {
    echo $c->column_name . ' (' . $c->data_type . ")\n";
}
echo "\n";
$row = DB::table('siswas')->first();
echo json_encode($row);
