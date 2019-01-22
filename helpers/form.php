<?php

/*
 |-----------------------------------------------------------------
 | Form Helper
 |-----------------------------------------------------------------
 |
 | Reusable form functions
 |
 */

/**
 * Button
 * --------------------------------------------
 *
 * @param string $content The tag content
 * @param array $attributes The button attributes
 * @return string
 */
function button($content, $attributes = [])
{
    $build = '<button ';
    foreach ($attributes as $key => $value)
    {
        $build .= $key . '="' . $value . '"';
    }

    $build .= '>' . $content;
    $build .= '</button>';

    return $build;
}

/**
 * Clean String
 * --------------------------------------------
 *
 * @param string $string The string to clean
 * @return string
 */
function clean_string($string)
{
    $string = filter_var($string, FILTER_SANITIZE_STRING);
    $string = trim($string);

    return $string;
}

/**
 * Select
 * --------------------------------------------
 *
 * @param array $options Array of select options
 * @param string $name The select input name
 * @param string $selected The selected value
 * @param string $placeholder The select input placeholder text
 * @param string $class The select input class
 * @param string $attributes The select input attributes
 * @return string
 */
function select($options = [], $name = null, $selected = null, $placeholder = null, $class = null, $attributes = null)
{
    $build = '<select name="' . $name . '" class="' . $class . '" ' . $attributes . '>';
    $build .= ($placeholder == null) ? null : '<option value="">' . $placeholder . '</option>';

    foreach ($options as $key => $value)
    {
        if($selected != null && $key == $selected)
        {
            $build .= '<option value="' . $key . '" selected>' . $value . '</option>';
        }
        else
        {
            $build .= '<option value="' . $key . '">' . $value . '</option>';
        }
    }

    $build .= '</select>';

    return $build;
}

/**
 * Multi Select
 * --------------------------------------------
 *
 * @param array $options Array of select options
 * @param string $name The select input name
 * @param array $selected Array of selected values
 * @param string $placeholder The select input placeholder text
 * @param string $class The select input class
 * @param string $attributes The select input attributes
 * @return string
 */
function multi_select($options = [], $name = null, $selected = null, $placeholder = null, $class = null, $attributes = null)
{
    $build = '<select multiple name="' . $name . '" class="' . $class . '" ' . $attributes . '>';
    $build .= ($placeholder == null) ? null : '<option value="">' . $placeholder . '</option>';

    foreach ($options as $key => $value)
    {
        if($selected != null && is_array($selected))
        {
            if(in_array($key, $selected))
            {
                $build .= '<option value="' . $key . '" selected>' . $value . '</option>';
            }
            else
            {
                $build .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        else
        {
            $build .= '<option value="' . $key . '">' . $value . '</option>';
        }
    }
    
    $build .= '</select>';

    return $build;
}
