source ~/.bashrc

PATH=$PATH:$HOME/bin
export PATH

#
# XDebug Config
#
export XDEBUG_CONFIG="idekey=PHPSTORM"
alias xdebugoff='sudo mv /etc/php.d/15-xdebug.ini  /etc/php.d/15-xdebug.ini.no && sudo service php-fpm restart'
alias xdebugon='sudo mv /etc/php.d/15-xdebug.ini.no /etc/php.d/15-xdebug.ini  && sudo service php-fpm restart'