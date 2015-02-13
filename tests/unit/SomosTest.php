<?php

namespace Somos;

use Mockery as m;

class SomosTest extends \PHPUnit_Framework_TestCase
{
    /** @var Actions */
    private $actions;

    /** @var m\MockInterface */
    private $messagebus;

    /** @var Somos */
    private $fixture;

    /**
     * Set up the dependencies and the fixture that we are going to test.
     */
    public function setUp()
    {
        $this->actions    = $this->givenAnActionsCollection();
        $this->messagebus = $this->givenAMessageBus();
        $this->fixture    = new Somos($this->messagebus, $this->actions);
    }

    /**
     * Re-set all properties to null to trigger clean up of these objects and save memory.
     */
    public function tearDown()
    {
        $this->actions    = null;
        $this->messagebus = null;
        $this->fixture    = null;
    }

    public function testSomosRequiresAnActionCollectionandMessageBus()
    {
        $this->assertAttributeSame($this->messagebus, 'messagebus', $this->fixture);
        $this->assertAttributeSame($this->actions, 'actions', $this->fixture);
    }

    public function testActionsCanBeRegisteredWithSomos()
    {
        $action = $this->givenAnExampleAction();

        $result = $this->fixture->add($action);

        $this->assertSame($action, $this->actions[0]);
        $this->assertSame($this->fixture, $result);
    }

    public function testSomosCanHandleAMessageToACommand()
    {
        $message = $this->givenAnExampleMessage();
        $this->thenMessagebusHasMessage($this->messagebus, $message);

        $result = $this->fixture->handle($message);

        $this->assertSame($this->fixture, $result);
    }

    /**
     * Returns a mock instance for a message bus.
     *
     * @return m\MockInterface
     */
    private function givenAMessageBus()
    {
        return m::mock('SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware');
    }

    /**
     * Returns a collection object for actions.
     *
     * @return Actions
     */
    private function givenAnActionsCollection()
    {
        return new Actions();
    }

    /**
     * Returns an example action object that can be used to populate the MessageBus with; no command is able to handle
     * this.
     *
     * @return Action
     */
    private function givenAnExampleAction()
    {
        return Action::get('/');
    }

    /**
     * Returns a mock of an object implementing the message interface.
     *
     * @return m\MockInterface
     */
    private function givenAnExampleMessage()
    {
        return m::mock('SimpleBus\Message\Message');
    }

    /**
     * Asserts that the messagebus receives the given message to handle.
     *
     * @param m\MockInterface $messagebus
     * @param m\MockInterface $message
     *
     * @return void
     */
    private function thenMessagebusHasMessage($messagebus, $message)
    {
        $messagebus->shouldReceive('handle')->once()->with($message);
    }
}
