<?php

namespace App\Command;

use App\Model\Test;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:test',
    description: 'Add a short description for your command',
)]
class TestCommand extends Command
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        parent::__construct();

        $this->serializer = $serializer;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $data = $this->serializer->serialize(new Test(), 'xml');
        $io->comment('Serialized data:');
        $io->writeln($data);
        $this->serializer->deserialize($data, Test::class, 'xml');


        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
