<?php
$file = 'app/Views/admin/employes.php';
$content = file_get_contents($file);

// Insert <form action="/admin/employes" method="post"> after <!-- Formulaire ajout -->
$content = str_replace(
    '<!-- Formulaire ajout -->',
    '<!-- Formulaire ajout -->' . "\n" . '<form action="/admin/employes" method="post">' . "\n" . '<?= csrf_field() ?>',
    $content
);

// We need to close the form. Let's find where the submit button is.
$content = preg_replace(
    '/(<button class="btn-forest" style="padding:8px 16px">.*?Sauvegarder.*?<\/button>\s*<\/div>\s*<\/div>)/is',
    '$1' . "\n" . '</form>',
    $content
);

file_put_contents($file, $content);
echo "Form updated.\n";
