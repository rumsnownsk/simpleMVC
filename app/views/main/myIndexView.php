<!--Подключён файл ВИДА: <code style="color: forestgreen">--><?//= __FILE__ ?><!--</code>-->

<br>

<div class="container">
    <h1><?= $title ?></h1>
    <?php if (!empty($posts)) : ?>
        <ul>Таблица постов:</ul>
        <?php foreach ($posts as $post) : ?>

            <div class="panel panel-default">
                <div class="panel-heading"><?= $post['title'] ?></div>
                <div class="panel-body">
                    <?= $post['text'] ?>
                </div>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>
</div>
