<?php

use Javan\LaravelFormBuilder\Fields\RepeatedType;
use Javan\LaravelFormBuilder\Form;

class RepeatedTypeTest extends FormBuilderTestCase
{

    /**
     * @var Form
     */
    protected $form;

    public function setUp()
    {
        parent::setUp();
        $this->form = (new Form())->setFormHelper($this->formHelper);
    }

    /** @test */
    public function it_creates_repeated_as_two_inputs()
    {
        $this->fieldExpetations('text', Mockery::any());
        $this->fieldExpetations('text', Mockery::any());
        $this->fieldExpetations('repeated', Mockery::any());

        $repeated = new RepeatedType('password', 'repeated', $this->form, []);

        $repeated->render();

        $this->assertEquals(2, count($repeated->getChildren()));

        $this->assertInstanceOf('Javan\LaravelFormBuilder\Fields\InputType', $repeated->first);
        $this->assertInstanceOf('Javan\LaravelFormBuilder\Fields\InputType', $repeated->second);
        $this->assertNull($repeated->third);
    }

    /** @test */
    public function it_checks_if_field_rendered_by_children()
    {
        $this->fieldExpetations('text', Mockery::any());
        $this->fieldExpetations('text', Mockery::any());
        $this->fieldExpetations('repeated', Mockery::any());

        $repeated = new RepeatedType('password', 'repeated', $this->form, []);

        $this->assertFalse($repeated->isRendered());

        $repeated->first->render();

        $this->assertTrue($repeated->isRendered());
    }
}