<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Kohana CLI Reloaded
 *
 * @package    CLI
 * @category   Controllers
 * @author     Sebicas
 */
class Controller_Cli_Demo extends Controller {

    function action_index()
    {
        // Clear Screen to Start
        CLI::clear_screen();

        // Line Break
        CLI::new_line();

        // White in Yellow
        CLI::write(' Kohana CLI Reloaded by @sebicas'.PHP_EOL, 'yellow');
        CLI::write('  '.PHP_EOL);

        // 2 Line Breaks
        CLI::new_line();

        // Regular White
        CLI::write(' Mostly ported from FuelPHP Framework'.PHP_EOL);

        // 2 Line Breaks
        CLI::new_line();
    }

}