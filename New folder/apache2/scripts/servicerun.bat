@echo off
rem START or STOP Apache Service
rem --------------------------------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

net start wappstackApache
goto end

:stop

"C:/Users/Tan Boon Joon/Desktop/shareStuff_cs2102/New folder/apache2\bin\httpd.exe" -n "wappstackApache" -k stop

:end
exit
