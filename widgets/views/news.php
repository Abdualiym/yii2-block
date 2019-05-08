<?php Yii::$app->formatter->locale = Yii::$app->language?>

<ul class="list-1">
    <?php foreach ($news as $item): ?>

    <li>
        <time class="the-date"><?= $item['date'] != 0 ? Yii::$app->formatter->asDate($item['date']) : Yii::$app->formatter->asDate($item['created_at'] )?></time>
        <div class="list-title"><a href="<?=
            abdualiym\menu\entities\Menu::getSlug(
                $item['translations'][0]['slug'],
                'content',
                $item['id'],
                \abdualiym\languageClass\Language::getLangByPrefix(Yii::$app->language)) ?>"><?= $item['translations'][0]['title'] ?></a></div>
        <div class="list-desc"><?= \yii\helpers\StringHelper::truncateWords($item['translations'][0]['description'],25)  ?>
        </div>
    </li>
    <?php endforeach; ?>
</ul>
<!-- list-1 end-->