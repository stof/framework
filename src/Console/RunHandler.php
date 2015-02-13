<?php

namespace Somos\Console;

use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;
use Somos\Actions;
use Symfony\Component\Console\Application;

class RunHandler implements MessageHandler
{
    /** @var Application */
    private $console;

    /** @var Actions */
    private $actions;

    public function __construct(Application $console, Actions $actions)
    {
        $this->console = $console;
        $this->actions = $actions;
    }

    /**
     * Handles the given message.
     *
     * @param Message $message
     *
     * @return void
     */
    public function handle(Message $message)
    {
        $this->console->setName('Somos');
        $this->console->setVersion('1.0.0');
        foreach ($this->actions as $action) {
            if ($action->getMatcher() instanceof Command) {
                $this->console->add($action->getMatcher());
                $action->getMatcher()->registerAction(array($action, 'handle'));
            }
        }
        $this->console->run();
    }
}