<?php

// app/Http/Controllers/CourseController.php
namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(12);   // or ->get()
        return view('course', compact('courses'));   // resources/views/course.blade.php
    }

    public function show(Course $course)             // route-model binding via slug
    {
        return view('course-details', compact('course'));
    }
}
