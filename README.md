EasyBackups (by ViscaWeb)
===================

[![Build Status](https://travis-ci.org/Viscaweb/EasyBackups.svg?branch=master)](https://travis-ci.org/Viscaweb/EasyBackups)
[![StyleCI](https://styleci.io/repos/51551977/shield?style=flat)](https://styleci.io/repos/51551977)


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
| .tar.gz      | :white_check_mark: |
| .tar.bz2     | :white_check_mark: |
| .zip         | :white_check_mark: |

How to install and use this script?
------------
Available soon...

To do
------------
Some improvements to achieve on this project:

| Status / Priority           | Suggestion |
| :-------------------------: | :--------- |
| Planned as next improvement | Complete the README with the installation steps |
| Planned as next improvement | Delete old backups automatically |
| #1 priority                 | Verify the integrity of the backups |
| #2 priority                 | Support more file systems (in progress) |
| #2 priority                 | Complete the battery of tests (in progress) |
| To be defined               | Provide an API to ensure the backups exists and is valid |
| To be defined               | Send final report by emails |
| To be defined               | Support more compressors |
| To be defined               | Use a known project to handle the API (with a swagger documentation) |
| To be defined               | Being able to download backups from the tools through a command |
| To be defined               | Create differential backups (instead of full backups) |
| To be defined               | Detect when the temporary folder does not have enough free space to welcome the backup |
| To be defined               | Exporting MySQL: hiding the message 'Warning: Using a password on the command line interface can be insecure.' |
| To be defined               | Write meta-data about the backups (in order to retrieve them easily later) |
| To be defined               | Detect when the difference of size of two consecutive backups is significant (@kristianmu) |
