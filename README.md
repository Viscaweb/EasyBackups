EasyBackups (by ViscaWeb)
===================

[![Build Status](https://travis-ci.org/Viscaweb/EasyBackups.svg?branch=master)](https://travis-ci.org/Viscaweb/EasyBackups)

EasyBackups a little (and very light-weight) library helping in the process
of backuping databases, files, etc..

What can be dumped?
------------
Currently, the script support:
- Databases
  - MySQL (through mysqldump)

How to install and use this script?
------------
Available soon...

To do
------------
Some improvements to achieve on this project:

* Support more file systems (in progress)
* Write tests (in progress)
* Complete the README with the installation steps
* Send final report by emails
* Being able to download backups from the tools through a command
* Create differential backups (instead of full backups)
* Being able to export files
* Support more compressors
* Detect when the temporary folder does not have enough free space to welcome the backup
* Exporting MySQL: hiding the message 'Warning: Using a password on the command line interface can be insecure.'
* Write meta-data about the backups (in order to retrieve them easily later)
* Delete old backups automatically
* Provide an API to ensure the backups exists and is valid
* Option to export the dump of each tables in a single file (@kristianmu)
* Detect when the difference of size of two consecutive backups is significant (@kristianmu)
* Verify the integrity of the backups