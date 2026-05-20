<?php
$files = ['app/Views/employe/demande.php', 'app/Views/admin/employes.php', 'app/Views/auth/login.php'];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Add validation base structure mapping
    // Quick structural modifications aren't easy safely without context, 
    // will just echo message on what needs to be done.
    echo "Found $file\n";
}
