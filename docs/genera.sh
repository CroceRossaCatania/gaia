#!/bin/bash
cd ~/gaia
phpdoc run -p --directory=. --ignore=core/inc/dompdf/*,core/class/Mail/* -title=Gaia --defaultpackagename=Gaia --target=docs
rm -Rf output/
rm -Rf php*
rm -Rf docs/php*
