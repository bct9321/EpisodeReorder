@echo off
:start
cls
set executeRename=false

echo +-+-+-+-+-+-+-+ +-+-+-+-+-+-+
echo EPISODE PARSER
echo +-+-+-+-+-+-+-+ +-+-+-+-+-+-+
echo.

:setfilepath
set validPath=false
echo Enter Season File Path:
set /p filePath=""
if "%filePath%"=="" goto setfilepath

:setseason
set /p season="Enter Season Number: "
if '%season%'=='' goto setseason

:renameScript
php rename.php "%filePath%" %season% %executeRename%

:executerename
if '%executeRename%'=='true' (
	set /p choice="Type Q to quit or M to restart: "
) else ( 
	set /p choice="Type Y to apply Q to quit or M to restart:"
)
	
if '%choice%'=='' goto executerename

if '%choice%'=='Y' (
	set executeRename=true
	goto renameScript
)
if '%choice%'=='M' (
	goto start
)
if '%choice%'=='Q' (
	exit
)