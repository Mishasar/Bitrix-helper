<?php
/**
 * Пользовательские константы
 */

const ASSETS_PATH = '/local/assets/';
const SALE_PRICE_ID = 17;
const STORE_BARNAUL_ID = 5;
const STORE_MOSCOW_ID = 7;
const PROPERTY_ARTICLES = 'CML2_TRAITS';
const GROUP_MANAGER_ID = 14;
const PROPERTY_NEW = 'MOSHCHNOST_1';
const PROPERTY_WEIGHT = 'VES_ZA_EDENITSU';
const PROPERTY_CAPACITY = 'OBEM_ZA_EDENITSU';
const PROPERTY_NAME = 'NAIMENOVANIE_NA_SAYTE';
const PROPERTY_ASSOCIATED_PRODUCTS = 'SOPUTSTVUYUSHCHAYA_NOMENKLATURA';
const PROPERTY_COLOR_LIGHT = 'TEMPERATURA_SVECHENIYA_';

//Температура свечения
const COLOR_LIGHT_LEFT_BORDER_DEG = 1800;
const COLOR_LIGHT_RIGHT_BORDER_DEG = 6600;


const INVISIBLE_PROPS = [
    PROPERTY_NEW,
    PROPERTY_WEIGHT,
    PROPERTY_NAME,
    PROPERTY_CAPACITY,
    PROPERTY_ARTICLES,
    PROPERTY_ASSOCIATED_PRODUCTS
];

const PROPERTIES_SECTION = [
    [
        'NAME' => 'Подсветка',
        'FIELDS' => [
            'MOSHCHNOST',
            'SVETOVOY_POTOK',
            'TSVET_SVECHENIYA',
            'NAPRYAZHENIE',
            PROPERTY_COLOR_LIGHT
        ]
    ],
    [
        'NAME' => 'Подсветка',
        'FIELDS' => [
            'VES_GRAMM',
            'DLINA_UPAKOVKI_MM',
            'SHIRINA_UPAKOVKI_MM',
            'VYSOTA_UPAKOVKI_MM',
            'RAZMERY_MM',
            'RAZMER_UPAKOVKI_DKHSHKHV_MM'
        ]
    ]
];

/**
 * Highload блоки
 */

const HL_BONUS = 1;

/**
 * Инфоблоков
 */
const IB_CATALOG = 5;
const IB_SLIDER = 6;
const IB_PROPS = 7;
const IB_ADVANTAGES = 8;
const IB_VIDEO = 9;
const IB_BONUS_SYSTEM = 10;


