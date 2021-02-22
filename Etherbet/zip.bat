@echo off
set workdir=%cd%

cd x:\xampp\htdocs\

c:\cygwin64\bin\zip -r "%workdir%\archive.zip" . -DF --out "%workdir%\new.zip"
c:\cygwin64\bin\zip -rq "%workdir%\archive.zip" .
