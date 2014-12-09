<?php

use Javan\LaravelFormBuilder\FormHelper;

class FormHelperTest extends FormBuilderTestCase
{

    /** @test */
    public function it_sets_constructor_dependencies_to_properties()
    {
        $this->assertEquals($this->view, $this->formHelper->getView());
        $this->assertEquals($this->request, $this->formHelper->getRequest());
    }

    /** @test */
    public function it_merges_options_properly()
    {
        $initial = [
            'attr' => ['class' => 'form-control'],
            'label_attr' => ['class' => 'test'],
            'selected' => null
        ];

        $options = [
            'attr' => ['id' => 'form-id'],
            'label_attr' => ['class' => 'new-class'],
        ];

        $expected = [
            'attr' => ['class' => 'form-control', 'id' => 'form-id'],
            'label_attr' => ['class' => 'new-class'],
            'selected' => null
        ];

        $mergedOptions = $this->formHelper->mergeOptions($initial, $options);

        $this->assertEquals($expected, $mergedOptions);
    }

    /** @test */
    public function it_gets_proper_class_for_specific_field_type()
    {
        $input = $this->formHelper->getFieldType('text');
        $select = $this->formHelper->getFieldType('select');
        $textarea = $this->formHelper->getFieldType('textarea');
        $submit = $this->formHelper->getFieldType('submit');
        $reset = $this->formHelper->getFieldType('reset');
        $button = $this->formHelper->getFieldType('button');
        $radio = $this->formHelper->getFieldType('radio');
        $checkbox = $this->formHelper->getFieldType('checkbox');
        $choice = $this->formHelper->getFieldType('choice');
        $repeated = $this->formHelper->getFieldType('repeated');

        $this->assertEquals('Javan\\LaravelFormBuilder\\Fields\\InputType', $input);
        $this->assertEquals('Javan\\LaravelFormBuilder\\Fields\\SelectType', $select);
        $this->assertEquals('Javan\\LaravelFormBuilder\\Fields\\TextareaType', $textarea);
        $this->assertEquals('Javan\\LaravelFormBuilder\\Fields\\ButtonType', $submit);
        $this->assertEquals('Javan\\LaravelFormBuilder\\Fields\\ButtonType', $reset);
        $this->assertEquals('Javan\\LaravelFormBuilder\\Fields\\ButtonType', $button);
        $this->assertEquals('Javan\\LaravelFormBuilder\\Fields\\CheckableType', $radio);
        $this->assertEquals('Javan\\LaravelFormBuilder\\Fields\\CheckableType', $checkbox);
        $this->assertEquals('Javan\\LaravelFormBuilder\\Fields\\ChoiceType', $choice);
        $this->assertEquals('Javan\\LaravelFormBuilder\\Fields\\RepeatedType', $repeated);
    }

    /** @test */
    public function it_throws_InvalidArgumentException_for_non_existing_field_type()
    {
        try {
            $this->formHelper->getFieldType('nonexisting');
        } catch (\InvalidArgumentException $e) {
            return;
        }

        $this->fail('Exception was not thrown for non existing field type');
    }

    /** @test */
    public function it_creates_html_attributes_from_array_of_options()
    {
        $options = ['class' => 'form-control', 'data-id' => 1, 'id' => 'post'];

        $attributes = $this->formHelper->prepareAttributes($options);

        $this->assertEquals(
            'class="form-control" data-id="1" id="post" ',
            $attributes
        );
    }

    /** @test */
    public function it_load_custom_field_types_from_config()
    {
        $config = $this->config;

        $config['custom_fields'][] = [
            'datetime' => 'App\Forms\DatetimeType'
        ];

        $formHelper = new FormHelper($this->view, $this->request, $config);
    }
}