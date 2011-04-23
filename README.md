Kohana CLI Reloaded
===================

The CLI Reloaded Class provides extended Command Line functionalities to Kohana 3

Mostly of the code has been extracted and adapted from:

**Fuel PHP Framework**
http://fuelphp.com

**Minion CLI framework for Kohana**
https://github.com/kohana-minion/core

How to use this module
----------------------

To use the **Kohana CLI Reloaded** Model, just:

1. Download and extract the code from [Github](https://sebicas@github.com/sebicas/kohana-cli-reloaded.git).
2. Place the module into your Kohana instances modules folder.
3. Enable the module within the application bootstrap within the section entitled `modules`.

Go to `application/bootstrap.php`, look for `Kohana::modules()` and add:

    'kohana-cli-reloaded' => MODPATH.'kohana-cli-reloaded', // Kohana CLI Reloaded

Example:

    Kohana::modules(array(
        // 'auth'       => MODPATH.'auth',       // Basic authentication
        // 'cache'      => MODPATH.'cache',      // Caching with multiple backends
        // 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
        // 'database'   => MODPATH.'database',   // Database access
        // 'image'      => MODPATH.'image',      // Image manipulation
        // 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
        // 'unittest'   => MODPATH.'unittest',   // Unit testing
        // 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
        'kohana-cli-reloaded' => MODPATH.'kohana-cli-reloaded', // Kohana CLI Reloaded
    ));

See it working
--------------

To see a **Demo** of the Module working go to the Module directory and type:

    ./kohana cli_demo

**Important**: Make sure./kohana file has executing permitions ( chmod +x ./kohana )

Contributing
------------

1. Fork it.
2. Create a branch (`git checkout -b my_markup`)
3. Commit your changes (`git commit -am "Added Snarkdown"`)
4. Push to the branch (`git push origin my_markup`)
5. Create an [Issue][1] with a link to your branch
6. Enjoy a refreshing orange juice and wait

Colaborators
------------

Thanks to the following colaborators:

* [sebicas](https://github.com/sebicas)