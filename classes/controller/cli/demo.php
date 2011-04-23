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
        CLI::write(' Kohana CLI Reloaded v0.1 beta by @sebicas'.PHP_EOL, 'yellow');
        CLI::write(' Mostly ported from FuelPHP Framework under MIT License'.PHP_EOL);
        CLI::write(' https://github.com/sebicas/kohana-cli-reloaded'.PHP_EOL);

        // Line Breaks
        CLI::new_line();

        // Ask a question
        $ready = CLI::read(' Are you ready for a demo?', array('y','n'));

        if($ready == 'n')
        {
            // User said no
            CLI::new_line();
            CLI::write(' Ok.. come back latter'.PHP_EOL);
            CLI::new_line();

            exit;
        }

        // Line Breaks
        CLI::new_line();
    }

}