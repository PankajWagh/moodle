<?php
function xmldb_codecheckbylanguage_upgrade($oldversion=0) {
    if ($oldversion < 2012091800) {
        // Add new fields to codecheckbylanguage table.
        $table = new xmldb_table('codecheckbylanguage');
   
       
        upgrade_mod_savepoint(true, 2012091800, 'codecheckbylanguage');
    }
}
?>