@echo off
rem -- Check if argument is INSTALL or REMOVE

if not ""%1"" == ""INSTALL"" goto remove

"C:/Users/Tan Boon Joon/Desktop/shareStuff_cs2102/New folder/apache2\bin\httpd.exe" -k install -n "wappstackApache" -f "C:/Users/Tan Boon Joon/Desktop/shareStuff_cs2102/New folder/apache2\conf\httpd.conf"

net start wappstackApache >NUL
goto end

:remove
rem -- STOP SERVICE BEFORE REMOVING

net stop wappstackApache >NUL
"C:/Users/Tan Boon Joon/Desktop/shareStuff_cs2102/New folder/apache2\bin\httpd.exe" -k uninstall -n "wappstackApache"

:end
exit
