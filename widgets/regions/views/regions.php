<?php

//\yii\helpers\VarDumper::dump($texts, 10, true);
//die;
?>

<div class="sidebar-address widget contact-info sticky_elem">
    <select>
        <?php foreach ($texts as $text) {
            echo '<option>' . $text->translations[0]->title . '</option>';
        } ?>
    </select>
    <ul class="c-info-list">
        <?php
        $i = 0;
        foreach ($texts as $text) { ?>
            <li class="<?= $i === 0 ? 'active' : '' ?>">
                <dl class="c-info-address">
                    <dt>Адрес</dt>
                    <?php foreach ($text->metaFields as $meta) {
                        if ($meta->key === 'region_name' && $meta->lang_id == $language['id']) {
                            echo '<dd>' . $meta->value . '</dd>';
                        }
                    } ?>
                    <?php foreach ($text->metaFields as $meta) {
                        if ($meta->key === 'region_mail') {
                            echo '<dd>' . $meta->value . '</dd>';
                        }
                        if ($meta->key === 'region_phone') {
                            echo '<dd>' . $meta->value . '</dd>';
                        }
                        if ($meta->key === 'region_site') {
                            echo '<dd>' . $meta->value . '</dd>';
                        }
                    } ?>
                </dl>
            </li>
            <?php $i++;
        } ?>
    </ul>
    <a class="addresses-link" href="http://uzonline.uz/ru/contacts/offices/"><?= Yii::t('app', 'Addresses of sales offices UZTELECOM') ?></a>
</div>