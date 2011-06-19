<?php defined('SYSPATH') or die('No direct script access.');

/**
 * The CLI Reloaded Class provides extended Command Line functionalities to Kohana
 *
 * Most of the code has been ported from:
 *
 * Fuel PHP Framework
 * http://fuelphp.com
 *
 * Minion CLI framework for Kohana
 * https://github.com/kohana-minion/core
 *
 * @package    CLI
 * @author     sebicas
 * @copyright  (c) 2008-2011 Kohana Team
 * @license    http://kohanaphp.com/license
 */
class CLI_Reloaded extends Kohana_CLI {

    // Replace for your Executable
    const executable = 'kohana ';

    // User Message
    public static $wait_msg = 'Press any key to continue...';

    protected static $foreground_colors = array
    (
        'black'         => '0;30',
        'dark_gray'     => '1;30',
        'blue'          => '0;34',
        'light_blue'    => '1;34',
        'green'         => '0;32',
        'light_green'   => '1;32',
        'cyan'          => '0;36',
        'light_cyan'    => '1;36',
        'red'           => '0;31',
        'light_red'     => '1;31',
        'purple'        => '0;35',
        'light_purple'  => '1;35',
        'brown'         => '0;33',
        'yellow'        => '1;33',
        'light_gray'    => '0;37',
        'white'         => '1;37',
    );

    protected static $background_colors = array
    (
        'black'         => '40',
        'red'           => '41',
        'green'         => '42',
        'yellow'        => '43',
        'blue'          => '44',
        'magenta'       => '45',
        'cyan'          => '46',
        'light_gray'    => '47',
    );

    /**
     * Throw Kohana Exception if is not running from CLI
     *
     * @author sebicas
     */
    static public function check()
    {
        if ( ! Kohana::$is_cli)
        {
            // Show Error Message
            echo "<B>Fatal Error:</B> ";
            echo "Kohana CLI can only be ran from the command line ... Sorry :)";

            // Break Execution
            exit;
        }
    }

    /**
     * Run Indicated Controller in the Command Line
     *
     * @author sebicas
     */
    static public function run($controller, array $arguments = NULL)
    {
        // Set Command to Execute
        $cmd = CLI::executable.' '.$controller;

        // Adding Arguments;
        if(!is_null($arguments) AND is_array($arguments))
        {
            // Adding Arguments
            foreach($arguments as $name => $value)
            {
                $cmd .= ' --'.$name.'='.$value;
            }
        }

        // Executing Kohana
        passthru($cmd);
    }

    /**
     * Reads input from the user. This can have either 1 or 2 arguments.
     *
     * Usage:
     *
     * // Waits for any key press
     * CLI::read();
     *
     * // Takes any input
     * $color = CLI::read('What is your favorite color?');
     *
     * // Will only accept the options in the array
     * $ready = CLI::read('Are you ready?', array('y','n'));
     *
     * @author     Fuel Development Team
     * @license    MIT License
     * @copyright  2010 - 2011 Fuel Development Team
     * @link       http://fuelphp.com
     *
     * @return string the user input
     */
    public static function read()
    {
        $args = func_get_args();

        // Ask question with options
        if (count($args) == 2)
        {
            list($output, $options) = $args;
        }

        // No question (probably been asked already) so just show options
        elseif (count($args) == 1 && is_array($args[0]))
        {
            $output = '';
            $options = $args[0];
        }

        // Question without options
        elseif (count($args) == 1 && is_string($args[0]))
        {
            $output = $args[0];
            $options = array();
        }

        // Run out of ideas, EPIC FAIL!
        else
        {
            $output = '';
            $options = array();
        }

        // If a question has been asked with the read
        if (!empty($output))
        {
            $options_output = '';
            if (!empty($options))
            {
                $options_output = ' ( '.implode(' / ', $options).' )';
            }

            fwrite(STDOUT, $output.$options_output.': ');
        }

        // Read the input from keyboard.
        $input = trim(fgets(STDIN));

        // If options are provided and the choice is not in the array, tell them to try again
        if (!empty($options) && !in_array($input, $options))
        {
            CLI::write('This is not a valid option. Please try again.'.PHP_EOL);

            $input = CLI::read($output, $options);
        }

        // Read the input
        return $input;
    }

    /**
     * Experimental feature.
     *
     * Reads hidden input from the user
     *
     * Usage:
     *
     * $password = CLI::password('Enter your password : ');
     *
     * @author Mathew Davies
     * @return string
     */
    public static function password($text = '')
    {
        if (Kohana::$is_windows)
        {
            $vbscript = sys_get_temp_dir().'CLI_Password.vbs';

            // Create temporary file
            file_put_contents($vbscript, 'wscript.echo(InputBox("'.addslashes($text).'"))');

            $password = shell_exec('cscript //nologo '.escapeshellarg($command));

            // Remove temporary file.
            unlink($vbscript);
        }
        else
        {
            $password = shell_exec('/usr/bin/env bash -c \'read -s -p "'.escapeshellcmd($text).'" var && echo $var\'');
        }

        CLI::new_line();

        return trim($password);
    }

    /**
     * Outputs a string to the cli. If you send an array it will implode them
     * with a line break.
     *
     * @author     Fuel Development Team
     * @license    MIT License
     * @copyright  2010 - 2011 Fuel Development Team
     * @link       http://fuelphp.com
     *
     * @param string|array $text the text to output, or array of lines
     */
    public static function write($text = '', $foreground = NULL, $background = NULL)
    {
        if (is_array($text))
        {
            $text = implode(PHP_EOL, $text);
        }

        if ($foreground OR $background)
        {
            $text = CLI::color($text, $foreground, $background);
        }

        fwrite(STDOUT, $text);
    }

    /**
     * Waits a certain number of seconds, optionally showing a wait message and
     * waiting for a key press.
     *
     * @author     Fuel Development Team
     * @license    MIT License
     * @copyright  2010 - 2011 Fuel Development Team
     * @link       http://fuelphp.com
     *
     * @param int $seconds number of seconds
     * @param bool $countdown show a countdown or not
     */
    public static function wait($seconds = 0, $countdown = FALSE)
    {
        if ($countdown === TRUE)
        {
            $time = $seconds;

            while ($time > 0)
            {
                // Display Count Down
                self::write($time.' ... ');

                sleep(1);

                $time--;
            }


        }
        else
        {
            if ($seconds > 0)
            {
                sleep($seconds);
            }
            else
            {
                CLI::write(CLI::$wait_msg);
                CLI::read();
            }
        }
    }

    /**
     * Returns the given text with the correct color codes for a foreground and
     * optionally a background color.
     *
     * @author     Fuel Development Team
     * @license    MIT License
     * @copyright  2010 - 2011 Fuel Development Team
     * @link       http://fuelphp.com
     *
     * @param string $text the text to color
     * @param atring $foreground the foreground color
     * @param string $background the background color
     *
     * @return string the color coded string
     */
    public static function color($text, $foreground, $background = NULL)
    {
        if (Kohana::$is_windows)
        {
            return $text;
        }

        if (!array_key_exists($foreground, CLI::$foreground_colors))
        {
            throw new Kohana_Exception('Invalid CLI foreground color: '.$foreground);
        }

        if ($background !== NULL and !array_key_exists($background, CLI::$background_colors))
        {
            throw new Kohana_Exception('Invalid CLI background color: '.$background);
        }

        $string = "\033[".CLI::$foreground_colors[$foreground]."m";

        if ($background !== NULL)
        {
            $string .= "\033[".CLI::$background_colors[$background]."m";
        }

        $string .= $text."\033[0m";

        return $string;
    }

    /**
     * Outputs an error to the CLI using STDERR instead of STDOUT
     *
     * @author     Fuel Development Team
     * @license    MIT License
     * @copyright  2010 - 2011 Fuel Development Team
     * @link       http://fuelphp.com
     *
     * @param	string|array	$text	the text to output, or array of errors
     */
    public static function error($text = '', $foreground = 'light_red', $background = NULL)
    {
        if (is_array($text))
        {
            $text = implode(PHP_EOL, $text);
        }

        if ($foreground OR $background)
        {
            $text = self::color($text, $foreground, $background);
        }

        fwrite(STDERR, $text);
    }

    /**
     * Beeps a certain number of times.
     *
     * @author     Fuel Development Team
     * @license    MIT License
     * @copyright  2010 - 2011 Fuel Development Team
     * @link       http://fuelphp.com
     *
     * @param	int $num	the number of times to beep
     */
    public static function beep($num = 1)
    {
        echo str_repeat("\x07", $num);
    }

    /**
     * Enter a number of empty lines
     *
     * @author     Fuel Development Team
     * @license    MIT License
     * @copyright  2010 - 2011 Fuel Development Team
     *
     * @param	integer	Number of lines to output
     * @return	void
     */
    public static function new_line($num = 1)
    {
        // Do it once or more, write with empty string gives us a new line
        for($i = 0; $i < $num; $i++)
        {
            self::write(PHP_EOL);
        }
    }

    /**
     * Clears the screen of output
     *
     * @author     Fuel Development Team
     * @license    MIT License
     * @copyright  2010 - 2011 Fuel Development Team
     *
     * @return	void
     */
    public static function clear_screen()
    {
        if(Kohana::$is_windows)
        {
            self::new_line(40);
        }
        else
        {
            // Anything with a flair of Unix will handle these magic characters
            fwrite(STDOUT, chr(27)."[H".chr(27)."[2J");
        }
    }

} // End CLI