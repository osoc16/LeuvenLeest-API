<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Http\Response;

class QuestionsController extends Controller
{
    public function getQuestions()
    {
        $questions = DB::table('questions')->get();
        return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),$questions, 200);
    }

    public function getRandomQuestion()
    {
        $questions = DB::table('questions')
            ->where('id', rand(1, 4))
            ->get();
        return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),$questions, 200);
    }

    public function getEvaluations($id)
    {
        $evaluations = DB::table('evaluations')
            ->join('questions', 'evaluations.questionId', '=', 'questions.id')
            ->where('placeId', $id)
            ->get();

        return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),$evaluations, 200);
    }

    public function evaluate($questionId, $placeId, $vote)
    {
        $evaluation = DB::table('evaluations')
            ->where('placeId', $placeId)
            ->where('questionId', $questionId)
            ->increment('votes');

        if ($vote == 0)
        {
            $evaluation = DB::table('evaluations')
                ->where('placeId', $placeId)
                ->where('questionId', $questionId)
                ->increment('ratingBad');
        }
        else if ($vote == 1)
        {
            $evaluation = DB::table('evaluations')
                ->where('placeId', $placeId)
                ->where('questionId', $questionId)
                ->increment('ratingGood');
        }

        return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),DB::table('evaluations')
            ->join('questions', 'evaluations.questionId', '=', 'questions.id')
            ->where('placeId', $placeId)
            ->get(),200);
    }

    public function getRating($placeId)
    {
        $evaluation = DB::table('evaluations')
            ->join('questions', 'evaluations.questionId', '=', 'questions.id')
            ->where('placeId', $placeId)
            ->get();

        $return = [];

        for ($i = 0; $i < 4; $i++)
        {
            switch ($i)
            {
                case 0: $up = 'Afgelegen'; $down = 'Druk';      break; // Drukte
                case 1: $up = 'Stil';      $down = 'Luid';      break; // Geluid
                case 2: $up = 'Groen';     $down = 'Stedelijk'; break; // Omgeving
                case 3: $up = 'Rustig';    $down = 'Levendig';  break; // Sfeer
            }

            if ($evaluation[$i]->ratingGood >= $evaluation[$i]->ratingBad)
            {
                $return[$i] = $up;
            }
            else
            {
                $return[$i] = $down;
            }
        }

        return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),$return,200);
    }
} 
