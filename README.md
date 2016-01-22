# AuthDataTransfer
Transfer ALL of your SimpleAuth YAML users to a MySQL database with a plugin.

## Notes

This plugin was coded and is maintained by Legoboy0215 of the Imagical Corporation. This is not a plugin for everyone, this is a plugin for our intended use. Hopefully you find it useful too.


#How-to

First of all this tutorial is meant for linux users.

So after you've AuthDataTransfer, close you're server and start it again. If the plugin is loaded you can stop it again.
If you did everything correctly there is a directory in you plugins folder called 'SimpleTransfer' in there there is a config.yml you need to edit. Just configure it so it can connect to you're mysql server. Then you need to go to you're mysql server (phpmyadmin) or something else and import the 'Simpleauth.sql' which is in the AuthDataTransfer directory. If you did everything above correctly you can start you're server and it will start transferring everything to the mysql server.

If you get this error: 

	[16:27:22] [Server thread/CRITICAL]: [SimpleTransfer] Unable to sumbit user to MySQL Database: Unknown Error. Disabling Plugin...
	[16:27:22] [Server thread/NOTICE]: [SimpleTransfer] 0 processed.
	[16:27:22] [Server thread/CRITICAL]: [SimpleTransfer] Unable to sumbit user to MySQL Database: Unknown Error. Disabling 	Plugin...
	[16:27:22] [Server thread/NOTICE]: [SimpleTransfer] 0 processed.
	[16:27:22] [Server thread/CRITICAL]: [SimpleTransfer] Unable to sumbit user to MySQL Database: Unknown Error. Disabling Plugin...
	[16:27:22] [Server thread/NOTICE]: [SimpleTransfer] 0 processed.
	[16:27:22] [Server thread/WARNING]: RuntimeException: "yaml_parse(): end of stream reached without finding document 0" (E_WARNING) in "/src/pocketmine/utils/Config" at line 143

There is most likely a corrupt .yml file so if you're running linux.
Run this command in you're server directory:
	 find plugins/SimpleAuth/players/ -type f -size 0k -exec ls {} \;
	
It will respond with something like this:
	plugins/SimpleAuth/players/b/player.yml
	plugins/SimpleAuth/players/b/test.yml
	
Just delete those because they are corrupt. If you delete the corrupt ones try and start you're server again and it should work!

If everything is transferred to you're database you need to edit the config.yml of SimpleAuth
By changing it to this:

dataProvider: mysql

	#for MySQL:
	dataProviderSettings:
 	host: "127.0.0.1"
 	port: 3306
 	user: "user"
 	password: "password"
 	database: "databaseName"
 	
If you did that you can start you're server again and everything should work now and all the players password are now in the database!
