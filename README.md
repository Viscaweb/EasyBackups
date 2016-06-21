EasyBackups (by ViscaWeb)
===================

[![Build Status](https://travis-ci.org/Viscaweb/EasyBackups.svg?branch=master)](https://travis-ci.org/Viscaweb/EasyBackups)

EasyBackups a little (and very light-weight) library helping in the process
of backuping databases, files, etc..

What can I dump?
------------
### Databases
| Platform | Implementation     |
| -------- | -----------------  |
| MySQL    | :white_check_mark: |

Where can I save the dumps?
------------
| Savers       | Implementation                 |
| ------------ | ------------------------------ |
| FileSystem   | :white_check_mark:             |
| FTP          | :white_check_mark:             |
| Amazon S3 V3 | :white_check_mark:             |
| Copy.com     | `create ticket if you need it` |
| Azure        | `create ticket if you need it` |
| DropBox      | `create ticket if you need it` |

Which compression software is currently supported?
------------
| Compression  | Implementation     |
| ------------ | -----------------  |
| .tar.xz      | :white_check_mark: |
| .tar.gz      | `to implement`     |
| .zip         | `to implement`     |

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
* Detect when the difference of size of two consecutive backups is significant (@kristianmu)
* Verify the integrity of the backups
* Use a known project to handle the API (with a swagger documentation)