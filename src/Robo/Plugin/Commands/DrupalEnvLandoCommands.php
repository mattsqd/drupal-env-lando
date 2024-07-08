<?php

namespace DrupalEnvLando\Robo\Plugin\Commands;

use DrupalEnv\Robo\Plugin\Commands\DrupalEnvCommandsBase;

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
     * Update the environment so that the scaffolding can happen, and run it.
     *
     * @command drupal-env-lando:scaffold
     */
    public function scaffold(string $package_name = ''): void
    {
        // Only reason this method is redefined is so that it can be given
        // a new @command name.
        parent::scaffold($package_name);
    }

    /**
     * {@inheritdoc}
     */
    protected function preScaffoldChanges(): void
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

}
