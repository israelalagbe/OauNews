<?php
//Your database configuration
return array(
            'driver'    => 'mysql', // Db driver
            'host'      => 'localhost',//Your webhost
            'database'  => 'jerry',//Your DataBase Name
            'username'  => 'root',//Your database username
            'password'  => '',//Your database password
			'charset'   => 'utf8', // Optional
            'collation' => 'utf8_unicode_ci', // Optional
            'prefix'    => '', // Table prefix, optional
            'options'   => array( // PDO constructor options, optional
                PDO::ATTR_TIMEOUT => 5,
                PDO::ATTR_EMULATE_PREPARES => false,
            ),
	);
/*
For pgsql database
return array(
                    'driver'   => 'pgsql',
                    'host'     => 'localhost',
                    'database' => 'your-database',
                    'username' => 'postgres',
                    'password' => 'your-password',
                    'charset'  => 'utf8',
                    'prefix'   => 'cb_',
                    'schema'   => 'public',
                );
For sqlite database 
return array(
                'driver'   => 'sqlite',
			    'database' => 'your-file.sqlite',
			    'prefix'   => 'cb_',
		    );
```
*/
?>