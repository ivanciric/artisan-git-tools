<?php
namespace Hamato\ArtisanGitTools\Console;

use Illuminate\Console\Command;

class TimetravelCommand extends Command {

    protected $signature = 'gittools:timetravel';
    protected $description = 'Command for resetting the origin to your branch state.';

    protected $commitHash;
    protected $localBranch;
    protected $remoteBranch;

    protected $gitCommands = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info("Brace yourself - you're going to timetravel!");

        $this->commitHash = $this->ask('Enter the commitHash to which you want the current branch to be reset:');
        $this->localBranch = $this->ask('Enter local branch name you wish to reset the remote to:');
        $this->remoteBranch = $this->ask('Enter remote branch name you wish to reset:');

        $this->line(
            "You want to reset the remote branch {$this->remoteBranch} \nto the state of your branch {$this->localBranch} \nwith this commit hash {$this->commitHash}.\n"
        );

        if (!$this->confirm('Do you wish to continue? [y|N]'))
        {
            $this->line("Not enough mana to cast spell.. ByeBye! \n\n");

            exit();
        }

        $this->timetravel();
    }

    private function timetravel()
    {
        $this->gitCommands = [
            "git checkout {$this->localBranch}",
            "git reset --hard {$this->commitHash}",
            "git checkout -b new-temp-branch",
            "git branch -m {$this->localBranch} old-temp-branch",
            "git branch -m new-temp-branch {$this->remoteBranch}",
            "git branch -d --force old-temp-branch",
            "git merge -s ours origin/{$this->remoteBranch}",
            "git push --set-upstream origin old-temp-branch",
            "git push",
            "git pull",
        ];

        $bar = $this->output->createProgressBar(count($this->gitCommands));

        foreach($this->gitCommands as $gitCommand)
        {
            exec($gitCommand);

            $bar->advance();
        }

        $bar->finish();

        $this->line("\n\nDone!\n\n");
    }
}
