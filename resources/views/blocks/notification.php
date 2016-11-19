<?
/**
 * A 'message' variable is a must!
 * 'message' => [
 *      'type' => 'success/info/warning/error',
 *      'text' => 'abc'
 * ]
 */

if (!in_array($type, ['success', 'info', 'warning', 'danger'])) return;

?>
    <div class="alert alert-<?= safe($type, 'info') ?>">
        <?= $text ?>
    </div>
<?