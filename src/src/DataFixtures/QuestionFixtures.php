<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture
{
    protected $fixtures = [
        [
            'text' => '1 + 1 = ',
            'answers' => [
                [
                    'value' => '3',
                    'is_correct' => false,
                ],
                [
                    'value' => '2',
                    'is_correct' => true,
                ],
                [
                    'value' => '0',
                    'is_correct' => false,
                ],
            ],
        ],
        [
            'text' => '2 + 2 = ',
            'answers' => [
                [
                    'value' => '4',
                    'is_correct' => true,
                ],
                [
                    'value' => '3+1',
                    'is_correct' => true,
                ],
                [
                    'value' => '10',
                    'is_correct' => false,
                ],
            ],
        ],
        [
            'text' => '3 + 3 = ',
            'answers' => [
                [
                    'value' => '1+5',
                    'is_correct' => true,
                ],
                [
                    'value' => '1',
                    'is_correct' => false,
                ],
                [
                    'value' => '6',
                    'is_correct' => true,
                ],
                [
                    'value' => '2+4',
                    'is_correct' => true,
                ],
            ],
        ],
        [
            'text' => '4 + 4 = ',
            'answers' => [
                [
                    'value' => '8',
                    'is_correct' => true,
                ],
                [
                    'value' => '4',
                    'is_correct' => false,
                ],
                [
                    'value' => '0',
                    'is_correct' => false,
                ],
                [
                    'value' => '0+8',
                    'is_correct' => true,
                ],
            ],
        ],
        [
            'text' => '5 + 5 = ',
            'answers' => [
                [
                    'value' => '6',
                    'is_correct' => false,
                ],
                [
                    'value' => '18',
                    'is_correct' => false,
                ],
                [
                    'value' => '10',
                    'is_correct' => true,
                ],
                [
                    'value' => '9',
                    'is_correct' => false,
                ],
                [
                    'value' => '0',
                    'is_correct' => false,
                ],
            ],
        ],
        [
            'text' => '6 + 6 = ',
            'answers' => [
                [
                    'value' => '3',
                    'is_correct' => false,
                ],
                [
                    'value' => '9',
                    'is_correct' => false,
                ],
                [
                    'value' => '0',
                    'is_correct' => false,
                ],
                [
                    'value' => '12',
                    'is_correct' => true,
                ],
                [
                    'value' => '5 + 7',
                    'is_correct' => true,
                ],
            ],
        ],
        [
            'text' => '7 + 7 = ',
            'answers' => [
                [
                    'value' => '5',
                    'is_correct' => false,
                ],
                [
                    'value' => '14',
                    'is_correct' => true,
                ],
            ],
        ],
        [
            'text' => '9 + 9 = ',
            'answers' => [
                [
                    'value' => '18',
                    'is_correct' => true,
                ],
                [
                    'value' => '9',
                    'is_correct' => false,
                ],
                [
                    'value' => '17 + 1',
                    'is_correct' => true,
                ],
                [
                    'value' => '2 + 16',
                    'is_correct' => true,
                ],
            ],
        ],
        [
            'text' => '10 + 10 = ',
            'answers' => [
                [
                    'value' => '0',
                    'is_correct' => false,
                ],
                [
                    'value' => '2',
                    'is_correct' => false,
                ],
                [
                    'value' => '8',
                    'is_correct' => false,
                ],
                [
                    'value' => '20',
                    'is_correct' => true,
                ],
            ],
        ],
    ];


    public function load(ObjectManager $manager)
    {
        foreach ($this->fixtures as $fixture) {
            $question = (new Question())
                ->setText($fixture['text']);

            foreach ($fixture['answers'] as $answer) {
                $answer = (new Answer())
                    ->setQuestion($question)
                    ->setValue($answer['value'])
                    ->setIsCorrect($answer['is_correct']);

                $manager->persist($answer);
            }
            $manager->persist($question);
        }

        $manager->flush();
    }
}
