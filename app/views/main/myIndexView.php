<!--Подключён файл ВИДА: <code style="color: forestgreen">--><? //= __FILE__ ?><!--</code>-->

<br>

<div class="container">
    <button class="btn btn-default" id="send">ajax кнопка</button>
    <div id="answer"></div>
    <?php new \app\core\widgets\menu\Menu([
        'tpl' => WWW . '/menu/select.php',
        'container' => 'select',
        'table' => 'categories',
        'cache' => 60,
        'class' => 'my_select',
        'cacheKey' => 'menu_select'
    ]) ?>

    <?php new \app\core\widgets\menu\Menu([
        'tpl' => WWW . '/menu/my_menu.php',
        'container' => 'ul',
        'table' => 'categories',
        'cache' => 60,
        'class' => 'my_menu',
        'cacheKey' => 'menu_ul'
    ]) ?>
    <ul class="nav nav-pills">
        <?php foreach ($menu as $item) : ?>
            <li><a href="category/<?= $item->id ?>"><?= $item->title ?></a></li>
        <?php endforeach; ?>

        <!--        <li role="presentation" class="active"><a href="#">Home</a></li>-->
        <!--        <li role="presentation"><a href="#">Profile</a></li>-->
        <!--        <li role="presentation"><a href="#">Messages</a></li>-->
    </ul>
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

<script src="/js/test.js"></script>
<script>
    $(function () {
        $('#send').click(function () {
            $.ajax({
                url: '/main/ajax',
                type: 'post',
                data: {'id': 2},
                success: function (res) {
                    // var data = JSON.parse(res);
                    // $('#answer').html('<p>Ответ: ' + data.answer + ' | Код:' + data.code + '</p>');
                    $('#answer').html(res);
                    // console.log(res)
                },
                error: function () {
                    alert('ERROR AJAX')
                }
            })
        })
    })
</script>
