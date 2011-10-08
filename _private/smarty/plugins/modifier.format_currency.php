<?php
/**
 * $Header: /cvs/ukweb/insight.com/php-europe/corelib/smarty/plugins/modifier.format_currency.php,v 1.2 2006/09/21 23:22:18 randrews Exp $
 * $Name:  $
 */

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier
 * Name:     format_currency
 * Date:     Mar 30, 2006
 * Purpose:  Takes a number and formats it using the correct localised currency formatting
 * Input:
 *         - contents = contents to replace
 * Example:  {$price|format_currency}
 * @version  1.0
 * @author   Chris Scott
 * @param    $price string containing price to be formatted.
 * @return   string containing formatted price.
 */

function smarty_modifier_format_currency($price, $decimal_places = null, $currency_code = null)
{
    return formatCurrency($price, $decimal_places, $currency_code);
}

 // {{{ formatCurrency

function formatCurrency($amount, $decimal_places = null, $currency_code = null)
{
	session_start();
	$currency =  $_SESSION['shopinfo']['currency_code'];
	switch($currency)
	{
		case 'USD':
		    $currency_format = "&#36;%%%";
		break;
		case 'EUR';
		    $currency_format = "&#8364;%%%";
		break;
		case 'GBP':
		default:
		    $currency_format = "&#163;%%%";
		break;
	}
	if($currency_code === 0){
		$currency_format = "%%%";
	}

    // Fetch other required formatting rules
    $negative_format = "-%%%";
    if (is_null($decimal_places))
    {
        $decimal_places = 2;
    }

    // Perform basic formatting on the number (excluding negativity)
    $num = formatNumber(abs($amount), $decimal_places);

    // Handle negative amount
    if ($amount < 0)
    {
        if (strstr($negative_format, '###'))
        {
            // Check if we need to put the fully formatted
            // currency string into the negative formatting
            return str_replace('###', formatCurrency(abs($amount)), $negative_format);
        }
        elseif (strstr($negative_format, '%%%'))
        {
            // Check if we need to put the partially formatted
            // number inside the negative formatting
            // and then apply the currency format
            $num = str_replace('%%%', $num, $negative_format);
        }
    }

    // Now apply the currency formatting and return it
    return str_replace('%%%', $num, $currency_format);

}

// {{{ formatNumber

function formatNumber($amount, $decimal_places = null)
{
    // Get all the rules we'll need
    $decimal_symbol = ".";
    $digit_grouping_symbol = ",";
    $decimal_leading_zero = true;
    $negative_format = "-%%%";
    // Get the standard number of dp's if decimal_places is true, or if it's not set and the number is not whole
    if ($decimal_places === true || (is_null($decimal_places) && strstr($amount, '.')))
    {
        $decimal_places = 2;
    }
    // Display as many decimal places as required
    elseif ($decimal_places == 'auto' && strpos($amount, '.') !== false)
    {
        $decimal_places = (strlen($amount) - 1) - strpos($amount, '.');
    }

    // Apply basic formatting to the number
    $num = number_format(abs($amount), $decimal_places, $decimal_symbol, $digit_grouping_symbol);

    // Add a leading zero if required
    if ($decimal_leading_zero && abs($amount) > 0 && abs($amount) < 1 && substr($num, 0, 1) != '0')
    {
        $num = '0' . $num;
    }

    // Handle negative amount
    if ($amount < 0)
    {
        // We don't care about currency formatting so
        // replace either ### or %%% with the number
        str_replace('###', $num, $negative_format);
        str_replace('%%%', $num, $negative_format);
    }

    return $num;
}

// }}}

// }}}
?>
