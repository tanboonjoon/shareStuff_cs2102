@echo off
rem -- Check if argument is INSTALL or REMOVE

if not ""%1"" == ""INSTALL"" goto remove

"C:\Users\Tan Boon Joon\Desktop\shareStuff_cs2102\New folder/postgresql\bin\pg_ctl.exe" register -N "wappstackPostgreSQL" -D "C:\Users\Tan Boon Joon\Desktop\shareStuff_cs2102\New folder/postgresql/data"

net start "wappstackPostgreSQL" >NUL
goto end

:remove
rem -- STOP SERVICE BEFORE REMOVING

net stop "wappstackPostgreSQL" >NUL
"C:\Users\Tan Boon Joon\Desktop\shareStuff_cs2102\New folder/postgresql\bin\pg_ctl.exe" unregister -N "wappstackPostgreSQL"


:end
exit
