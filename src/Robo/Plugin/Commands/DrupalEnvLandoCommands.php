<?php

namespace DrupalEnvLando\Robo\Plugin\Commands;

use DrupalEnv\Robo\Plugin\Commands\DrupalEnvCommandsBase;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Provide commands to handle installation tasks.
 *
 * @class RoboFile
 */
class DrupalEnvLandoCommands extends DrupalEnvCommandsBase
{

    /**
     * {@inheritdoc}
     */
    protected string $package_name = 'mattsqd/drupal-env-lando';

    /**
     * This is the entry point to allow Drupal env and it's plugins to scaffold.
     *
     * Run this to kick off once.
     *
     * @command drupal-env-lando:enable-scaffold
     */
    public function enableScaffoldCommand(SymfonyStyle $io): void
    {
        $this->enableScaffolding($io);
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeEnableScaffolding(SymfonyStyle $io): void
    {
        // Must make sure we remove any previous .lando.yml file as our scripts only
        // modify and the existing stuff will stay and mess things up.
        if (file_exists('.lando.yml') && !file_exists('.lando.dist.yml')) {
            if ($this->confirm('You already seem to have Lando configured locally. Continuing with this scaffolding will remove your current Lando configuration. Continue?')) {
                $this->taskFilesystemStack()
                    ->rename(".lando.yml", ".lando.yml.old")
                    ->run();
                if (file_exists('.lando.local.yml')) {
                    $this->taskFilesystemStack()
                        ->rename(".lando.local.yml", ".lando.local.yml.old")
                        ->run();
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function preScaffoldCommand(): array {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function postScaffoldCommand(): array {
        return [];
    }

}
