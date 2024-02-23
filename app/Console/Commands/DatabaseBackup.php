<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:database-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting database backup...');

        // Menggunakan backup job factory untuk membuat backup database
        $backupJob = BackupJobFactory::createFromArray(config('backup.backup'));

        // Menjalankan backup
        $backupJob->run();

        $this->info('Database backup completed successfully.');
    }
}
