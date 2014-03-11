vrsyslog
========

Visual iface for Rocket-fast SYStem for LOG processing

vrsyslog is a Graphical User Interface for rsyslog.
It performs basic analisys based on the log data, and let's you access raw log data.

Requirements / dependencies
---------------------------
- LAMP system
- rsyslog with mysql support

Installation
------------
- put public_html folder in a web accessible directory
(make sure the web server process has write access to the public_html/assets and public_html/protected/runtime folders)
- edit the configuration file public_html/protected/vrsyslog.ini to suite your needs

Read INSTALLATION_instructions.txt for more details.

Usage
-----
Point your browser to the vrsyslog host.
Default username and password are: admin / admin.
Use the Dashoboard view to get a quick snapshot of what's going on with your logs.
Use the Logs view to access raw log data.

