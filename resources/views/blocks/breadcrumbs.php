<ol class="breadcrumb">
    <? foreach ($breadcrumbs as $uri => $breadcrumb) {
        $nohref = $uri == 'javascript: void(0)' ? true : false;
        if ($nohref) { ?>
            <li><span><?= $breadcrumb ?></span></li>
        <? } else { ?>
            <li><a href="<?= $uri ?>"><?= $breadcrumb ?></a></li>
        <? }
    } ?>
</ol>