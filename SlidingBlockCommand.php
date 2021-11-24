<?php


use app\Game\Field;
use app\Game\GameState;
use app\Game\GameConfig;
use app\Solver\Solver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use app\Game;

final class SlidingBlockCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'solve';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $game = new GameConfig();
        $solver = new Solver();

        $start = microtime(true);
        $solution = $solver->solve($game);
        $duration =  microtime(true) - $start;

        if($solution instanceof GameState) {
            $solution->animate();

            $output->writeln(
                sprintf('Puzzle solved succesfully after %s iterations, and %s moves, in %s seconds',
                    $solver->getIterations(),
                    count($solution->getHistory()),
                    $duration
                )
            );
        }


        return Command::SUCCESS;
    }
}
