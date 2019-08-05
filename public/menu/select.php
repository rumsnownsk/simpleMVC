<option value="<?= $id ?>">
    <?= $tab . $category['title']; ?>
</option>
<?php if (isset($category['childs'])) : ?>
    <ul>
        <?= $this->getMenuHtml($category['childs'], '&nbsp;' . $tab. '- ') ?>
    </ul>
<?php endif; ?>