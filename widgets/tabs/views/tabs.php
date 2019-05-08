<?php
$class = 'active';
$parent = 0;
?>


<div class="sidebar-news">
    <ul class="news-tabs-nav">
        <?php $i = 0;
        foreach ($categories as $key => $cat) { ?>
            <li class="<?= $i == 0 ? $class : $parent = $key ?>">
                <a href="#news-tab-<?= $cat['id']; ?>">
                    <?= $cat['translations'][0]['name'] ?>
                </a>
            </li>
            <?php $i++;
        } ?>
    </ul>


    <!-- news-tabs-nav end-->
    <div class="news-tabs">
        <?php foreach ($texts as $key => $items): ?>
            <div class="<?= $key != $parent ? $class : '' ?>" id="news-tab-<?= $key ?>">
                <ul class="list-1 grids-1">
                    <?php foreach ($items as $item): ?>
                        <li>
                            <time class="the-date"><?= $item['date'] ?? $item['created_at'] ?></time>
                            <div class="list-title">
                                <a class="smaller-fs" href="<?= $item['translations'][0]['slug'] ?>"><?= $item['translations'][0]['title'] ?></a>
                            </div>
                            <div class="list-desc"><?= $item['translations'][0]['description'] ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?= $categories[$key]['translations'][0]['slug'] ?>"><?= Yii::t('app', 'Мore info') ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- sidebar-news end-->