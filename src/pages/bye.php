
<?php $name = $request->get('name') ?? ''; ?>

Thank you <?= htmlspecialchars(isset($name) ? $name : 'Visitor', ENT_QUOTES, 'UTF-8'); ?>!

