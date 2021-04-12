<?php


/**
 * функция, которая обрезает текстовое содержимое если оно превышает заданное число символов
 * @param string $description текстовое содержимое
 * @param integer $length заданное число символов
 * @return string Возвращает обрезанное  текстовое содержимое
 */

function truncate(
    string $description,
    int $length = 300
): string {
    //  выпилил  все html теги из текста
    $description = htmlspecialchars(trim($description));

    if (mb_strlen($description) <= $length) {
        return sprintf('<p>%s</p>', $description);
    }
    $words = ' ';
    // разбил текст на отдельные слова (по пробелам)
    $description = explode(' ', $description);
    //  в цикле последовательно считаю длину каждого слова
    foreach ($description as $word) {
        $words .= $word . ' ';
        if (mb_strlen($words) < $length) {
            continue;
        }
        return sprintf('<p>%s%s</p>%s', $words, "&hellip;", "<a class='post-text__more-link' href='#'>Читать далее</a>");
    }
}



