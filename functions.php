<?php

declare(strict_types = 1);

/**
 * @param string $text
 * @return array|null
 */
function parse_sms(string $text): ?array
{
    preg_match_all('/(\D|^)((\d+)([,.](\d{1,2}))?\s?[рr])/miu', $text, $matches, PREG_SET_ORDER);

    if (empty($matches) || count($matches) > 1) {
        return null;
    }

    $amount = (int) ($matches[0][3] . str_pad($matches[0][5] ?? '00', 2, '0'));
    $textWithoutAmount = str_replace($matches[0][2], '', $text);

    preg_match_all('/(\D|^)(\d{3,8})(\D|$)/mu', $textWithoutAmount, $matches, PREG_SET_ORDER);

    if (empty($matches) || count($matches) > 1) {
        return null;
    }

    $password = $matches[0][2];

    preg_match_all('/(\D|^)(\d{10,20})(\D|$)/mu', $textWithoutAmount, $matches, PREG_SET_ORDER);

    if (empty($matches) || count($matches) > 1) {
        return null;
    }

    $id = $matches[0][2];

    return [$password, $amount, $id];
}
