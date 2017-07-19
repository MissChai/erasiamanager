<?php

namespace ErasiaManagerAPI\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Validator\Constraints    as Constraints;

class CharacterType extends AbstractType {

	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder->add( 'name', Type\TextType::class, array(
			'constraints' => array(
				new Constraints\NotBlank( array(
					'message' => 'Your character name is mandatory.'
				)),
				new Constraints\Length( array(
					'min'        => 1,
					'max'        => 255,
					'minMessage' => 'Your character name is too short.',
					'maxMessage' => 'Your character name is too long.',
				)),
			),
		));

		$builder->add( 'points', Type\IntegerType::class, array(
			'constraints' => array(
				new Constraints\GreaterThan( array(
					'value'   => -1,
					'message' => 'Your character can not have negative points.',
				)),
			),
		));

		$builder->add( 'color', Type\TextType::class, array(
			'constraints' => array(
				new Constraints\Length( array(
					'max'        => 255,
					'maxMessage' => 'What color name is longer than {{ limit }} characters?',
				)),
			),
		));
	}

	public function getName() {
		return 'character';
	}
}