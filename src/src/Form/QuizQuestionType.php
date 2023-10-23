<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\QuizQuestion;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var QuizQuestion $quiz */
            $quizQuestion = $event->getData();

            $form = $event->getForm();

            $form
                ->add('question', TextType::class, [
                    'label' => false, // Устанавливаем метку на false
                    'data' => $quizQuestion->getQuestion(), // Устанавливаем текст вопроса
                    'disabled' => true, // Блокируем редактирование
                    // Другие опции, если необходимо
                ])
                ->add('answers', EntityType::class, [
                    'class' => Answer::class,
                    'label' => false,
                    'choice_label' => 'value',
                    'multiple' => true,
                    'expanded' => true,
                    'query_builder' => function (EntityRepository $er) use ($quizQuestion) {
                        return $er->createQueryBuilder('a')
                            ->where('a.question = :question')
                            ->setParameter('question', $quizQuestion->getQuestion());
                    },
                ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuizQuestion::class,
        ]);
    }
}
