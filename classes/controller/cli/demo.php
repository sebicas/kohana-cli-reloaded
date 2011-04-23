<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Kohana CLI Reloaded Demo
 *
 * @package    CLI
 * @category   Controllers
 * @author     sebicas
 */
class Controller_Cli_Demo extends Controller {

    function action_index()
    {
        // Ckeck if is CLI
        CLI::check();

        // Clear Screen to Start
        CLI::clear_screen();

        // Line Break
        CLI::new_line();

        // White in Yellow
        CLI::write(' Kohana CLI Reloaded v0.1 beta by @sebicas'.PHP_EOL, 'yellow');
        CLI::write(' Mostly ported from FuelPHP Framework & Minion under MIT License'.PHP_EOL);
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

} // End Controller_Cli_Demo