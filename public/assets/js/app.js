/**
 * Загружает пирожки с фильтрацией, сортировкой и пагинацией
 * @param {number} offset - Смещение для пагинации
 */
function loadPirozhki(offset = 0) {
    const fillings = $("input[type=checkbox]:checked").map(function () {
        return $(this).parent().text().trim();
    }).get();
    const dough = $(".filter__select").val();
    const sort = $(".pirozhki__sort-button--active").data("sort");

    const limit = 5;

    $.get("api/get_pirozhki.php", {
        fillings: fillings,
        dough: dough,
        sort: sort,
        offset: offset,
        limit: limit
    }).done(function (data) {
        if (offset === 0) $(".pirozhki__list").empty();

        // Добавляем пирожки
        data.forEach(function (item) {
            $(".pirozhki__list").append(`
        <div class="pirozhki__card card">
          <div class="card__price">${item.price} Р</div>
          <div class="card__info">
            <div class="card__field"><span class="card__label">Начинка</span>${item.filling}</div>
            <div class="card__field"><span class="card__label">Срок изгот.</span>${formatTime(item.prep_time)}</div>
            <div class="card__field"><span class="card__label">Тесто</span>${item.dough}</div>
          </div>
        </div>
      `);
        });

        if (data.length < limit) {
            $(".pirozhki__more-button").hide();
        } else {
            $(".pirozhki__more-button").show();
        }
    }).fail(function () {
        alert("Ошибка загрузки пирожков");
    });
}

/**
 * Форматирует время в минутах в формат ЧЧММ
 * @param {number} mins
 * @returns {string}
 */
function formatTime(mins) {
    const h = Math.floor(mins / 60);
    const m = mins % 60;
    return `${h}ч ${m}м`;
}

$(document).ready(function () {
    let offset = 0;
    const limit = 5;

    loadPirozhki();

    $(".pirozhki__sort-button").click(function () {
        $(".pirozhki__sort-button").removeClass("pirozhki__sort-button--active");
        $(this).addClass("pirozhki__sort-button--active");
        offset = 0;
        loadPirozhki();
    });

    $(".filter__form").on("change", "input, select", function () {
        offset = 0;
        loadPirozhki();
    });

    $(".pirozhki__more-button").click(function () {
        offset += limit;
        loadPirozhki(offset);
    });

    $(".pirozhki__form").submit(function (e) {
        e.preventDefault();

        const data = {
            price: $(this).find("input[placeholder='Цена']").val(),
            filling: $(this).find("select").eq(0).val(),
            prep_time: $(this).find("input[type='number']").val(),
            dough: $(this).find("select").eq(1).val()
        };

        $.ajax({
            url: "api/add_pirozhok.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(data),
            success(res) {
                var success = document.createElement('p');
                success.innerHTML = "<div id='success' style='color: green;'>Пирожок добавлен!</div>";

                if ($("#success").length === 0) {
                    $(".pirozhki__form").append(success);
                }
                loadPirozhki();
            },
            error(xhr) {
                const errors = xhr.responseJSON.errors || ["Ошибка при добавлении"];

                var error = document.createElement('p');
                error.innerHTML = "Ошибка: " + errors.join(" или ");

                if ($("#error").length === 0) {
                    $(".pirozhki__form").append(error);
                }
            }
        });
    });
});