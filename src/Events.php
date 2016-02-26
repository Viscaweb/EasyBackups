<?php

final class Events
{
    /**
     * Thrown when the backup process begins.
     *
     * @var string
     */
    const BACKUP_BEGINS = 'backup.begins';

    /**
     * Thrown when the backup process ends.
     *
     * @var string
     */
    const BACKUP_ENDS = 'backup.ends';

    /**
     * Thrown each time a temporary file is created.
     * The event listener receives Event\FileCreatedEvent instance.
     *
     * @var string
     */
    const FILE_TEMPORARY_CREATE = 'file_temporary.create';

}
