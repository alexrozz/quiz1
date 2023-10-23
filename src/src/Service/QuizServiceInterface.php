<?php

namespace App\Service;

use App\Entity\Quiz;

interface QuizServiceInterface
{
    /**
     * Creates the quiz
     *
     * @return Quiz
     */
    public function createQuiz() : Quiz;

    /**
     * Gets correct answered questions
     *
     * @param Quiz $quiz
     * @return array
     */
    public function getCorrectQuestions(Quiz $quiz): array;

    /**
     * Gets incorrect answered questions
     *
     * @param Quiz $quiz
     * @return array
     */
    public function getIncorrectQuestions(Quiz $quiz): array;
}