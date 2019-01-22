<?php

/*
 |-----------------------------------------------------------------
 | Bootstrap
 |-----------------------------------------------------------------
 |
 | Classes, libraries, languages, helpers etc. to auto start when
 | the application starts running.
 |
 */

/**
 *-----------------------------
 * Models
 *
 * Models to bootstrap when system initializes
 * @example $bootstrap['model'] = ['login', 'menu', 'user'];
 *
 */
$bootstrap['model'] = [
    'user-model'
];

/**
 *-----------------------------
 * Libraries
 *
 * Libraries to bootstrap when system initializes
 * @example $bootstrap['library'] = ['session', 'uri', 'email'];
 *
 */
$bootstrap['library'] = [
    'session',
    'security',
    'uri',
    'app',
    'input'
];

/**
 *-----------------------------
 * Languages
 *
 * Languages to bootstrap when system initializes
 * @example $bootstrap['language'] = ['form_lang', 'app_lang'];
 *
 */
$bootstrap['language'] = [
    'app_lang'
];

/**
 *-----------------------------
 * Helpers
 *
 * Helpers to bootstrap when system initializes
 * @example $bootstrap['helper'] = ['html', 'url', 'form'];
 *
 */
$bootstrap['helper'] = [
    'url',
    'html',
    'form',
    'date'
];
