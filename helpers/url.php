<?php

/*
 |-----------------------------------------------------------------
 | URL Helper
 |-----------------------------------------------------------------
 |
 | Reusable URL functions
 |
 */

/**
 * Site URL
 * --------------------------------------------
 *
 * @param mixed $address The url address
 * @example
 * [string] : site_url(gallery/videos)
 * [array] : site_url(['gallery', 'videos'])
 * Output : http://example.com/gallery/videos
 * @return string
 */
function site_url($address = null)
{
    $base_url = env('APP_URL');
    $url_type = env('APP_URL_TYPE');

    if($address !== null && $url_type === 'relative')
    {
        $url = '/';
    }
    elseif($address === null && $url_type === 'relative')
    {
        $url = null;
    }
    else
    {
        $url = ($address === null) ? $base_url : $base_url . '/';
    }

    $address = ($address === null) ? '/' : $address;

    if(is_string($address))
    {
        return $url . $address;
    }
    elseif(is_array($address))
    {
        return $url . implode("/", $address);
    }
}

/**
 * Current URL
 * --------------------------------------------
 *
 * @return string
 */
function current_url($append = null)
{
    $url = env('APP_URL');
    $append = ($append === null) ? null : $append;

    return $url . $_SERVER['REQUEST_URI'] . $append;
}

/**
 * URI String
 * --------------------------------------------
 *
 * @return string
 */
function uri_string()
{
    return $_SERVER['REQUEST_URI'];
}

/**
 * SEO URL Format
 * --------------------------------------------
 *
 * @param string $string The string to format
 * @param string $separator The string searator - or _
 * @param bool $lowercase Change string to all lowercase
 * @return string
 */
function seo_url($string, $separator, $lowercase = false)
{
    $allowed = ['-', '_'];

    if(in_array($separator, $allowed))
    {
        $string = preg_replace( '/[«»""\'\'!?,.!@£$%^&*{};:()]+/', '', $string );
        $string = preg_replace('/[^A-Za-z0-9-_]+/', $separator, $string);
        $string = ($lowercase) ? strtolower($string) : $string;
        return $string;
    }
    else
    {
        trigger_error("String separator {$separator} not allowed. Use dash - or underscore _");
    }
}

/**
 * Anchor
 * --------------------------------------------
 *
 * @param string $content The tag content
 * @param string $uri The uri string
 * @param array $attributes The button attributes
 * @return string
 */
function anchor($content, $uri, $attributes = [])
{
    $url = (env('APP_URL_TYPE') === 'absolute') ? site_url() : '/';

    $build = '<a href="' . $url . $uri . '" ';

    foreach ($attributes as $key => $value)
    {
        $build .= $key . '="' . $value . '"';
    }

    $build .= '>' . $content;
    $build .= '</a>';

    return $build;
}

/**
 * Asset
 * --------------------------------------------
 *
 * @param string $uri The uri string
 * @return string
 * @example asset('css/style.css');
 * Do not add slash (/) a the beginning or end
 */
function asset($uri)
{
    $url = (env('APP_URL_TYPE') === 'absolute') ? site_url() : '/';

    return $url . $uri;
}

/**
 * Redirect
 * --------------------------------------------
 *
 * @param string $url The url to redirect to
 * @param int $timeout Time in seconds before redirecting
 * @example redirect('/contact/phone', 5);
 * The above will redirect to /contact/phone after 5 seconds.
 * Note: Add a starting slash when using a uri or relative links
 * @return void
 */
function redirect($url, int $timeout = null)
{
    if($timeout !== null)
    {
        header("refresh: {$timeout};url = {$url}");
    }
    else
    {
        header("Location: {$url}");
    }
}

/**
 * Javascript Redirect
 * --------------------------------------------
 *
 * @param string $url The url to redirect to
 * @param int $timeout Time in seconds before redirecting
 * @example js_redirect('/contact/phone', 5);
 * The above will redirect to /contact/phone after 5 seconds.
 * Note: Add a starting slash when using a uri or relative links
 * @return void
 */
function js_redirect($url, int $timeout = null)
{
    // Convert seconds to milliseconds
    $timeout = ($timeout !== null) ? ($timeout * 1000) : $timeout;

    if($timeout !== null)
    {
        return "<script>window.setTimeout(function() {window.location.href = '{$url}';}, {$timeout});</script>";
    }
    else
    {
        return "<script>window.location = '{$url}';</script>";
    }
}

/**
 * HTTP Response Code
 * --------------------------------------------
 *
 * @param int $code The http response code
 * @param string $message The message to display
 * Throw an http status code header with message
 * Useful for outputing errors in Ajax requests
 * @return void
 */
function show_http_response($code, $message = null)
{
    $response = [
        403 => "403 Forbidden",
        404 => "404 Not Found",
        500 => "500 Internal Server Error"
    ];

    header("HTTP/1.1 " . $response[$code]);
    die($message);
}

/**
 * Active Nav Link
 * --------------------------------------------
 *
 * @param string $current Current url index
 * @param string $page The page to match with
 * @return string
 */
function active_nav($current, $page)
{
    if($current === $page)
    {
        return 'active';
    }
}
