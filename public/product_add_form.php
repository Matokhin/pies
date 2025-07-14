<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\PirozhokRepository;
use App\Validator;

$repo = new PirozhokRepository();
$initialPirozhki = $repo->getAll();

$fillings = [];
$doughs = [];

foreach ($initialPirozhki as $item) {
    $fillings[] = $item['filling'];
    $doughs[] = $item['dough'];
}

$uniqueFillings = array_unique($fillings);
$uniqueDoughs = array_unique($doughs);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Форма добавления пирожков</title>
    <link rel="stylesheet" href="/assets/styles.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/app.js" defer></script>
</head>
<body class="page">

    <!-- Кнопка открытия интерфейса -->
    <a href="/" class="main-link">
        <img src="img/Vector.svg" alt="Перейти на начальную страницу">
    </a>

    <!-- Основной контейнер -->
    <div class="layout">

        <!-- Фильтр -->
        <aside class="filter">
            <form method="get" action="/api/get_pirozhki.php"  class="filter__form">
                <fieldset name="fillings" class="filter__section">
                    <legend class="filter__title">Начинка</legend>
                    <?php foreach ($uniqueFillings as $filling): ?>
                        <label class="filter__option">
                            <input type="checkbox" name="filling[]" value="<?= htmlspecialchars($filling) ?>" checked />
                            <?= htmlspecialchars($filling) ?>
                        </label>
                    <?php endforeach; ?>
                </fieldset>
                <fieldset name="dough" class="filter__section">
                    <legend class="filter__title">Тесто</legend>
                    <select class="filter__select">
                        <option disabled selected>Выбрать</option>
                        <?php foreach ($uniqueDoughs as $dough): ?>
                            <option value="<?= htmlspecialchars($dough) ?>"><?= htmlspecialchars($dough) ?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>
            </form>
        </aside>

        <!-- Контейнер товаров -->
        <main class="pirozhki">

            <div class="pirozhki__sort">
                <button class="pirozhki__sort-button pirozhki__sort-button--active" data-sort="price">Самый дешёвый</button>
                <button class="pirozhki__sort-button" data-sort="time">Самый быстрый</button>
            </div>

            <!-- Карточки товара -->
            <div class="pirozhki__list">
                <?php foreach ($initialPirozhki as $item): ?>
                    <div class="pirozhki__card card">
                        <div class="card__price"><?= htmlspecialchars($item['price']) ?> Р</div>
                        <div class="card__info">
                            <div class="card__field"><span class="card__label">Начинка</span><?= htmlspecialchars($item['filling']) ?></div>
                            <div class="card__field"><span class="card__label">Срок изгот.</span><?= floor($item['prep_time'] / 60) ?>ч <?= $item['prep_time'] % 60 ?>м</div>
                            <div class="card__field"><span class="card__label">Тесто</span><?= htmlspecialchars($item['dough']) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="pirozhki__more-button">Показать ещё 5 пирожков!</button>

        </main>

        <!-- Форма добавления товара -->
        <form method="post" action="/api/add_pirozhok.php" class="pirozhki__form form" autocomplete="off">
            <div class="form__title">Форма</div>
            <div class="form__fields">
                <div class="form__input-wrapper">
                    <div class="form__input-title">Цена</div>
                    <input class="form__input" name="price" type="text" placeholder="Цена"/>
                </div>
                <div class="form__input-wrapper">
                    <div class="form__input-title">Начинка</div>
                    <select class="form__input select" name="filling">
                        <option disabled selected>Начинка</option>
                        <?php foreach ($uniqueFillings as $filling): ?>
                            <option><?=$filling?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form__input-wrapper">
                    <div class="form__input-title">Срок изготовления, минут</div>
                    <input class="form__input" name="prep_time" type="number" placeholder="Срок изготовления, минут"/>
                </div>
                    <div class="form__input-wrapper">
                        <div class="form__input-title">Тесто</div>
                        <select class="form__input select" name="dough">
                            <option disabled selected>Тесто</option>
                            <?php foreach ($uniqueDoughs as $dough): ?>
                                <option value="<?= htmlspecialchars($dough) ?>"><?= htmlspecialchars($dough) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            <label class="form__checkbox">
                <input type="checkbox" name="agreement" required checked />
                <span>Согласие на обработку персональных данных</span>
            </label>
            <button type="submit" class="form__submit">Отправить</button>
        </form>
    </div>
</body>
</html>
