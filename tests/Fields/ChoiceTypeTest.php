<?php

use Javan\LaravelFormBuilder\Fields\ChoiceType;
use Javan\LaravelFormBuilder\Fields\SelectType;
use Javan\LaravelFormBuilder\Form;

class ChoiceTypeTest extends FormBuilderTestCase
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
    public function it_creates_choice_as_select()
    {
        $options = [
            'attr' => ['class' => 'choice-class'],
            'selected' => 'yes'
        ];

        $this->fieldExpetations('select', Mockery::any());

        $this->fieldExpetations('choice', Mockery::any());

        $choice = new ChoiceType('some_choice', 'choice', $this->form, $options);

        $choice->render();

        $this->assertEquals(1, count($choice->getChildren()));

        $this->assertEquals('yes', $choice->getOption('selected'));
    }

    /** @test */
    public function it_creates_choice_as_checkbox_list()
    {
        $options = [
            'attr' => ['class' => 'choice-class-something'],
            'choices' => [1 => 'monday', 2 => 'tuesday'],
            'selected' => 'tuesday',
            'multiple' => true,
            'expanded' => true
        ];

        $this->fieldExpetations('checkbox', Mockery::any());

        $this->fieldExpetations('checkbox', Mockery::any());

        $this->fieldExpetations('choice', Mockery::any());

        $choice = new ChoiceType('some_choice', 'choice', $this->form, $options);

        $choice->render();

        $this->assertEquals(2, count($choice->getChildren()));

        $this->assertEquals('tuesday', $choice->getOption('selected'));

        $this->assertContainsOnlyInstancesOf('Javan\LaravelFormBuilder\Fields\CheckableType', $choice->getChildren());
    }

    /** @test */
    public function it_creates_choice_as_radio_buttons()
    {
        $options = [
            'attr' => ['class' => 'choice-class-something'],
            'choices' => [1 => 'yes', 2 => 'no'],
            'selected' => 'no',
            'expanded' => true
        ];

        $this->fieldExpetations('radio', Mockery::any());

        $this->fieldExpetations('radio', Mockery::any());

        $this->fieldExpetations('choice', Mockery::any());

        $choice = new ChoiceType('some_choice', 'choice', $this->form, $options);

        $choice->render();

        $this->assertEquals(2, count($choice->getChildren()));

        $this->assertEquals('no', $choice->getOption('selected'));

        $this->assertContainsOnlyInstancesOf('Javan\LaravelFormBuilder\Fields\CheckableType', $choice->getChildren());
    }
}