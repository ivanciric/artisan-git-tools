<?php
namespace Hamato\ArtisanGitTools\Console;

use Illuminate\Console\Command;

class OblivionCommand extends Command
{

    protected $signature = 'gittools:oblivion';
    protected $description = 'Command for removing an item from the repository, without removing it from the local filesystem.';

    protected $folderName;

    protected $gitCommands = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info("Be careful - you're staring into the oblivion!");

        $this->folderName = $this->ask('Enter the of the folder you want to remove from the repo (usually it\'s .idea...):');

        $this->line(
            "You are about to remove the {$this->remoteBranch} folder from the repository."
        );

        if (!$this->confirm('Do you wish to continue? [y|N]')) {
            $this->line("Not enough mana to cast spell.. ByeBye! \n\n");

            exit();
        }

        $this->oblivion();
    }

    private function oblivion()
    {
        $this->gitCommands = [
            "echo '{$this->folderName}' >> .gitignore",
            "git rm -r --cached {$this->folderName}",
            "git add .gitignore",
            "git commit -m 'removed {$this->folderName} from the repository.'",
            "git push",
        ];

        $bar = $this->output->createProgressBar(count($this->gitCommands));

        foreach ($this->gitCommands as $gitCommand) {
            exec($gitCommand);

            $bar->advance();
        }

        $bar->finish();

        $this->line("\n\nDone!\n\n");
    }
}
