<?php namespace Apiness\Support\Testing;

trait InteractsWithForms {

	/**
	 * Assert that an error for a given field is seen on the page.
	 *
	 * @param        $field
	 * @param string $error
	 * @param string $attribute
	 */
	public function seeErrorInForm($field, $error = 'validation.required', $attribute = 'validation.attributes')
	{
		$this->see(trans($error, [ 'attribute' => trans("$attribute.$field") ]));
	}

	/**
	 * Assert that an error for each given fields is seen on the page.
	 *
	 * @param array  $fields
	 * @param string $error
	 * @param string $attribute
	 */
	public function seeErrorsInForm(array $fields, $error = 'validation.required', $attribute = 'validation.attributes')
	{
		foreach ($fields as $field) {
			$this->see(trans($error, [ 'attribute' => trans("$attribute.$field") ]));
		}
	}

}
