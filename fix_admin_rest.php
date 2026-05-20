<?php
$file = 'app/Views/admin/employes.php';
$content = file_get_contents($file);

// Replace select departement
$content = preg_replace(
    '/<select class="f-select">\s*<option>IT<\/option>\s*<option>RH<\/option>\s*<option>Finance<\/option>\s*<option>Marketing<\/option>\s*<\/select>/s',
    '<select name="departement_id" class="f-select">
              <option value="">Sélectionner</option>
              <?php foreach($departements ?? [] as $d): ?>
              <option value="<?= $d[\'id\'] ?>" <?= set_select(\'departement_id\', $d[\'id\']) ?>><?= esc($d[\'nom\']) ?></option>
              <?php endforeach; ?>
            </select>
            <?php if (isset($validation) && $validation->getError(\'departement_id\')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;"><?= esc((string) $validation->getError(\'departement_id\')) ?></small>
            <?php endif; ?>',
    $content
);

// Replace select role
$content = preg_replace(
    '/<select class="f-select">\s*<option>Employé<\/option>\s*<option>Responsable RH<\/option>\s*<option>Administrateur<\/option>\s*<\/select>/s',
    '<select name="role" class="f-select">
              <option value="employe" <?= set_select(\'role\', \'employe\') ?>>Employé</option>
              <option value="rh" <?= set_select(\'role\', \'rh\') ?>>Responsable RH</option>
              <option value="admin" <?= set_select(\'role\', \'admin\') ?>>Administrateur</option>
            </select>
            <?php if (isset($validation) && $validation->getError(\'role\')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;"><?= esc((string) $validation->getError(\'role\')) ?></small>
            <?php endif; ?>',
    $content
);

// Replace date_embauche
$content = preg_replace(
    '/<input type="date" class="f-input" value="2025-06-13">/s',
    '<input type="date" name="date_embauche" class="f-input" value="<?= set_value(\'date_embauche\') ?>">
            <?php if (isset($validation) && $validation->getError(\'date_embauche\')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;"><?= esc((string) $validation->getError(\'date_embauche\')) ?></small>
            <?php endif; ?>',
    $content
);

file_put_contents($file, $content);
echo "Admin rest updated.\n";
