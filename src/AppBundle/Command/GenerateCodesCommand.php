<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Logger\ConsoleLogger;

use AppBundle\Lib\Generator;


class GenerateCodesCommand extends Command{
    
    protected function configure(){
        $this->setName('app:generate')
        ->setDescription('Generate uniqe codes.')
        ->setDefinition(new InputDefinition(
                [new InputOption('numberOfCodes','c', InputArgument::REQUIRED),
                 new InputOption('lengthOfCode','l', InputArgument::REQUIRED), 
                 new InputOption('file','f', InputArgument::OPTIONAL)]
                ))
        ->addArgument('numberOfCodes', InputArgument::REQUIRED, 'Number of codes')
        ->addArgument('lengthOfCode', InputArgument::REQUIRED, 'Lenght of code')
        ->addArgument('file', InputArgument::OPTIONAL, 'Name of file')
        ->setHelp('This command allows you to generate uniqe codes');
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $gen = new Generator(new ConsoleLogger($output));
        $gen->generate($input->getArgument('numberOfCodes'), 
                $input->getArgument('lengthOfCode'), 
                $input->getArgument('file'));
    }
    
}
