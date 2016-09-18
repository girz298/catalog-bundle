<?php
namespace CatalogBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('catalog:build')
            ->setDescription('Build CatalogBundle project.')
            ->setHelp("This command allows you to build...")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $output->writeln('Dropping database!');
        $command = $this->getApplication()->find('doctrine:database:drop');
        $some_input = new ArrayInput([
            'command' => 'doctrine:database:drop',
            '--force' => true
        ]);
        $return_code = $command->run($some_input, $output);
        if ($return_code === 0) {
            $output->writeln('Database was successfully dropped!');
        } else {
            $output->writeln('Something went wrong!');
        }

        $output->writeln("");

        $output->writeln('Creating database!');
        $command = $this->getApplication()->find('doctrine:database:create');
        $some_input = new ArrayInput(['command' => 'doctrine:database:create']);
        $return_code = $command->run($some_input, $output);
        if ($return_code === 0) {
            $output->writeln('Database was successfully create!');
        } else {
            $output->writeln('Something went wrong!');
        }

        $output->writeln("");

        $output->writeln('Creating database schema...');
        $command = $this->getApplication()->find('doctrine:schema:create');
        $some_input = new ArrayInput(['command' => 'doctrine:schema:create']);
        $return_code = $command->run($some_input, $output);
        if ($return_code === 0) {
            $output->writeln('Database Schema was successfully create!');
        } else {
            $output->writeln('Something went wrong!');
        }

        $output->writeln("");

        $output->writeln('Loading data into database...');
        $command = $this->getApplication()->find('doctrine:fixtures:load');
        $some_input = new ArrayInput(['command' => 'doctrine:fixtures:load']);
        $return_code = $command->run($some_input, $output);
        if ($return_code === 0) {
            $output->writeln('Data was successfully added!');
        } else {
            $output->writeln('Something went wrong!');
        }

        $output->writeln("");

        $output->writeln('Installing assets');

        $assetic = $this->getApplication()->find('assetic:dump');
        $some_input = new ArrayInput(['command' => 'assetic:dump']);
        $assetic_return = $assetic->run($some_input, $output);

        $assets = $this->getApplication()->find('assets:install');
        $some_input = new ArrayInput([
            'command' => 'assets:install',
            '--symlink' => true
        ]);
        $assets_return = $assets->run($some_input, $output);

        if ($assetic_return === 0 && $assets_return === 0) {
            $output->writeln('Assets was successfully installed!');
        } else {
            $output->writeln('Something went wrong!');
        }
    }

}