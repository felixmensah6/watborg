<?php

/*
 |-----------------------------------------------------------------
 | HTML Helper
 |-----------------------------------------------------------------
 |
 | Reusable HTML functions
 |
 */

/**
 * Header
 * --------------------------------------------
 *
 * @param string $content The tag content
 * @param int $type The header type H(1, 2, 3 etc.)
 * @param array $attributes The button attributes
 * @return string
 */
function heading($content, int $type, $attributes = [])
{
    $allowed = [1, 2, 3, 4, 5, 6];

    if(in_array($type, $allowed))
    {
        $build = '<h' . $type . ' ';

        foreach ($attributes as $key => $value)
        {
            $build .= $key . '="' . $value . '"';
        }

        $build .= '>' . $content;
        $build .= '</h' . $type . '>';

        return $build;
    }
    else
    {
        trigger_error("Unknown html heading type h{$type}. Headings are from h1 to h6 only.");
    }
}

/**
 * Link
 * --------------------------------------------
 *
 * @param string $content The tag content
 * @param string $href The hyperlink
 * @param array $attributes The button attributes
 * @return string
 */
function link_tag($content, $href, $attributes = [])
{
    $build = '<a href="' . $href . '" ';

    foreach ($attributes as $key => $value)
    {
        $build .= $key . '="' . $value . '"';
    }
    
    $build .= '>' . $content;
    $build .= '</a>';

    return $build;
}
