<?php

namespace Windqyoung\DemoService;


use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo-service:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install demo controller and routes';

    public function handle()
    {
        $toDir = __DIR__ . '/App/';

        $this->comment('Publishing demo service...');
        $this->comment('TO ' . $toDir);

        $files = (new Finder())->in(__DIR__ . '/stubs');
        foreach ($files as $file) {
            /**
             * @var \Symfony\Component\Finder\SplFileInfo $file
             */
            if ($file->isDir()) {
                continue;
            }

            $toFile = $toDir . $file->getRelativePathname();

            if ('stub' === pathinfo($toFile, \PATHINFO_EXTENSION)) {
                $toFile = substr($toFile, 0, -5);
            }

            $toFileDir = $toDir . $file->getRelativePath();

            if (file_exists($toFile)) {
                $this->warn('EXISTS ' . $toFile);
                continue;
            }

            if (! is_dir($toFileDir)) {
                mkdir($toFileDir, 0755, true);
                $this->comment('MKDIR ' . $toFileDir);
            }

            copy($file->getRealPath(), $toFile);

            $this->comment('COPY ' . $file->getRealPath() . "\n===> " . $toFile);
        }

        $this->info('demo service installed successfully.');
    }

}