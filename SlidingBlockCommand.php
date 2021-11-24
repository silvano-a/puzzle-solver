<?php


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
require_once __DIR__.'/Resources/Field.php';
require_once __DIR__.'/Resources/Queue.php';

final class SlidingBlockCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'solve';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $initMap = Field::getField();
        $queue = new Queue();

        $gamestate = new GameState();
        $gamestate->add($initMap);
        $queue->add($gamestate);

        while ($queue->isEmpty() === false) {
            Field::calculateNextMoves($queue);
        }

        $output->writeln('DONE');

        if($queue->winner !== null) {
            $output->writeln('Puzzel solved in ' . $queue->getIterations() . ' iterations');

            /** @var GameState $winner */
            $winner = $queue->winner;

            foreach($winner->getHistory() as $item) {
                $queue->print($item);
                usleep(200000);
            }

            $output->writeln('Amount of moves needed to reach destination: '. count($winner->getHistory()));
            $output->writeln('Number of iterations:' . $queue->getIterations());
        } else {
            $output->writeln('Puzzel not solvable');
        }

        return Command::SUCCESS;
    }
}
