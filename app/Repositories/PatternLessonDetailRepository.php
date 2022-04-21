<?php

namespace App\Repositories;

use App\Models\PatternLessonDetail;
use App\Models\PatternLessonFormula;
use App\Models\PatternLessonHighlight;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class PatternLessonDetailRepository
{
    public function create($data)
    {

        $lesson = new PatternLessonDetail();
        $lesson->code = Str::random(10);
        $lesson->lesson_title = $data['title'];
        $lesson->pattern_lesson_id = $data['pattern_lesson_id'];
        $lesson->save();

        $lid = $lesson->id;

        if ($lid > 0) {
            foreach ($data['highlights'] as $key => $value) {
                $highlight = new PatternLessonHighlight();
                $highlight->code = Str::random(15);
                $highlight->pattern_lesson_detail_id = $lid;
                $highlight->title_highlight = $value;
                $highlight->save();
            }

            foreach ($data['formulas'] as $value) {
                $formula = new PatternLessonFormula();
                $formula->code = Str::random(15);
                $formula->pattern_lesson_detail_id = $lid;
                $formula->content = $value;
                $formula->save();
            }
        }


        return $lesson;
    }

    public function update($data, $id, $did)
    {
        // nb : id -> lesson_id, did -> lesson_detail_id
        print_r($did);
        // dd($data);
        $lesson = PatternLessonDetail::find($did);
        $lesson->lesson_title = $data['title'];
        $lesson->pattern_lesson_id = $data['pattern_lesson_id'];
        $lesson->update();

        $h_array = array();
        $f_array = array();
        foreach ($data['highlights'] as $key => $value) {
            array_push($h_array, $value['id']);
        }
        foreach ($data['formulas'] as $key => $value) {
            array_push($f_array, $value['id']);
        }

        // chceking delete old inexists data
        $ex = PatternLessonHighlight::where('pattern_lesson_detail_id', $data['id'])
            ->whereNotIn('id', $h_array)->delete();

        $ex = PatternLessonFormula::where('pattern_lesson_detail_id', $data['id'])
            ->whereNotIn('id', $f_array)->delete();

        foreach ($data['highlights'] as $key => $value) {
            if ($value['id'] != null) {
                $highlight = PatternLessonHighlight::find($value["id"]);
                $highlight->title_highlight = $value['title'];
                $highlight->update();
            } else {
                $highlight = new PatternLessonHighlight();
                $highlight->code = Str::random(15);
                $highlight->pattern_lesson_detail_id = $id;
                $highlight->title_highlight = $value['title'];
                $highlight->save();
            }
        }

        foreach ($data['formulas'] as $value) {
            if ($value['id'] != null) {
                $formula = PatternLessonFormula::find($value['id']);
                $formula->content = $value['content'];
                $formula->update();
            } else {
                $answer = new PatternLessonFormula();
                $answer->code = Str::random(15);
                $answer->pattern_lesson_detail_id = $id;
                $answer->content = $value['content'];
                $answer->save();
            }
        }


        return $lesson;
    }
}
