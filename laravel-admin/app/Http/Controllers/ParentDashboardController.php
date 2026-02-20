<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ParentDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $parent = Auth::guard('parent')->user();
        $parent->load('students');

        // Get all results for parent's children
        $studentIds = $parent->students->pluck('id')->toArray();
        
        $query = Result::with('student')
            ->whereIn('student_id', $studentIds);

        // Filter by exam if provided
        if ($request->filled('exam')) {
            $query->where('exam_name', $request->exam);
        }

        // Filter by student if provided
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $results = $query->orderBy('exam_name')->orderBy('subject')->get();
        
        // Group results by student and exam
        $groupedResults = [];
        foreach ($results as $result) {
            $studentId = $result->student_id;
            $examName = $result->exam_name;
            
            if (!isset($groupedResults[$studentId])) {
                $groupedResults[$studentId] = [
                    'student' => $result->student,
                    'exams' => [],
                ];
            }
            
            if (!isset($groupedResults[$studentId]['exams'][$examName])) {
                $groupedResults[$studentId]['exams'][$examName] = [];
            }
            
            $groupedResults[$studentId]['exams'][$examName][] = $result;
        }

        $examTypes = Result::whereIn('student_id', $studentIds)
            ->distinct()
            ->pluck('exam_name')
            ->sort()
            ->values();

        return view('parent.dashboard', compact('parent', 'groupedResults', 'examTypes'));
    }
}
