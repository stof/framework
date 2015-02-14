<?php

namespace Somos\Console;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends SymfonyCommand
{
    private $action;

    public function __construct($name = null, $description = '')
    {
        $names = [];
        if ($name !== null) {
            $names = explode('|', $name);
            $name = array_shift($names);
        }

        parent::__construct($name);

        $this->setAliases($names);
        if (is_string($description)) {
            $this->setDescription($description);
        }
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        call_user_func_array($this->action, $input->getOptions());
    }

    public function registerAction(callable $action)
    {
        $this->action = $action;
    }
}