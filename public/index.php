<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\PirozhokRepository;

$repo = new PirozhokRepository();
$initialPirozhki = $repo->getAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Список с пирожками</title>
  <link rel="stylesheet" href="/assets/styles.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="/assets/js/app.js" defer></script>
</head>
<body class="page">

    <!-- Кнопка открытия интерфейса -->
    <a href="product_add_form.php" class="bottom-form-link">
        <img src="img/cake-svgrepo-com_1.png" alt="Перейти на страницу добавления товара">
    </a>

    <!-- Контейнер -->
    <div class="layout">
        <main class="pirozhki">

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

        <!-- Кнопка "Показать ещё" -->
        <button class="pirozhki__more-button">Показать ещё 5 пирожков!</button>
        </main>
    </div>
</body>
</html>
