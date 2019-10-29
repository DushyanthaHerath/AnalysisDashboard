<?php

use Illuminate\Database\Seeder;
use App\Store\Models\Result;

class ResultsTableSeeder extends Seeder
{
    const NUMBER_OF_RECORDS = 10000000;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generator = \Faker\Factory::create();
        $students = [];
        for ($i=0;$i<20;$i++) {
            array_push($students, [
                'id'=>'SID-'.($i+1),
                'name' => $generator->firstName().' '.$generator->lastName()
            ]);
        }

        $subjects = [
            'Mathematics',
            'Algebra',
            'Geometry',
            'Science',
            'Geography',
            'History',
            'English',
           /* 'Spanish',
            'German',
            'French',
            'Latin',
            'Greek',
            'Arabic',
            'Computer Science',
            'Art',
            'Economics',
            'Music',
            'Drama',
            'Physical Education',*/
        ];

        for ($i=0;$i<self::NUMBER_OF_RECORDS;$i++) {
            $result = new Result();
            $student = $generator->randomElement($students);
            $subject = $generator->randomElement($subjects);
            $mark = $generator->numberBetween($generator->numberBetween(10, 35), $generator->numberBetween(70, 100));
            $result->student_id = $student['id'];
            $result->name = $student['name'];
            $result->subject = $subject;
            $result->mark = $mark;
            $result->grade = $this->grade($mark);
            $result->semester = $generator->numberBetween(1,2);
            $result->calender_year = $generator->numberBetween(2009, 2019);
            $result->save();
        }
    }

    private function grade($mark) {

        if ($mark > 90.9)
            return 'A+';
        elseif ($mark > 85.9)
            return 'A ';
        elseif ($mark > 79)
            return 'A- ';
        elseif ($mark > 76.9)
            return 'B+ ';
        elseif ($mark >71.9)
            return 'B ';
        elseif ($mark > 69.9)
            return 'B- ';
        elseif ($mark > 65.9)
            return 'C+ ';
        elseif ($mark > 59.9)
            return 'C ';
        elseif ($mark > 54.9)
            return 'C- ';
        elseif ($mark > 34.9)
            return 'S ';
        else
            return 'F ';

    }
}
