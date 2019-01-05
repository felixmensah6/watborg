<?php

/*
 |-----------------------------------------------------------------
 | Bootstrap
 |-----------------------------------------------------------------
 |
 | Classes, libraries, functions etc. to auto start when
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
$bootstrap['model'] = [];

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
    'uri'
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
    'form'
];
