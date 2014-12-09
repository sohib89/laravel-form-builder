<?php

use Javan\LaravelFormBuilder\Fields\ButtonType;
use Javan\LaravelFormBuilder\Form;

class ButtonTypeTest extends FormBuilderTestCase
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
    public function it_creates_button()
    {
        $options = [
            'attr' => ['class' => 'btn-class', 'disabled' => 'disabled']
        ];

        $expectedOptions = $this->getDefaults(
            ['class' => 'btn-class', 'type' => 'button', 'disabled' => 'disabled'],
            'some_button'
        );

        $expectedViewData = [
            'name' => 'some_button',
            'type' => 'button',
            'options' => $expectedOptions,
            'showLabel' => true,
            'showField' => true,
            'showError' => true
        ];

        $this->fieldExpetations('button', $expectedViewData);

        $button = new ButtonType('some_button', 'button', $this->form, $options);

        $button->render();
    }

    /** @test */
    public function it_can_handle_object_with_getters_and_setters()
    {
        $expectedOptions = $this->getDefaults(['type' => 'submit'], 'save');

        $this->fieldExpetations('button', Mockery::any());

        $button = new ButtonType('save', 'submit', $this->form);

        $this->assertEquals('save', $button->getName());
        $this->assertEquals('submit', $button->getType());
        $this->assertEquals($expectedOptions, $button->getOptions());
        $this->assertFalse($button->isRendered());

        $button->setName('cancel');
        $button->setType('reset');
        $button->setOptions(['attr' => ['id' => 'button-id'], 'label' => 'Cancel it']);

        $expectedOptions = $this->getDefaults(['type' => 'submit', 'id' => 'button-id'], 'Cancel it');

        $this->assertEquals('cancel', $button->getName());
        $this->assertEquals('reset', $button->getType());
        $this->assertEquals($expectedOptions, $button->getOptions());

        $button->render();

        $this->assertTrue($button->isRendered());
    }

    /** @test */
    public function it_can_change_template_with_options()
    {
        $expectedOptions = $this->getDefaults(
            ['type' => 'submit'],
            'some_submit'
        );

        $expectedViewData = [
            'name' => 'some_submit',
            'type' => 'submit',
            'options' => $expectedOptions,
            'showLabel' => true,
            'showField' => true,
            'showError' => true
        ];

        $this->fieldExpetations('button', $expectedViewData, 'custom-template');

        $button = new ButtonType('some_submit', 'submit', $this->form, ['template' => 'custom-template']);

        $button->render();
    }

}
