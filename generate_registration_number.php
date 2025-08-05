<?php
function generateRegistrationNumber($id) {
    return 'V25C-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}
?>
