<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Syllabus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashCoursesController extends Controller
{
    
    public function InstructorCourses()
    {
        $instructor = auth()->guard('instructor')->user();
        if (!$instructor) {
            abort(403, 'Unauthorized');
        }
        $courses = Course::with([
            'syllabuses.lessons',
            'enrollments',
            'reviews'
        ])->where('instructor_id', $instructor->id)->get();

        return view('courses.instructorcourse', compact('courses'));
    }


    public function create()
{
    $categories = Category::all();
    return view('courses.create', compact('categories'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'overview' => 'nullable|string',
            'description' => 'nullable|string',
            'certifications' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('courses', 'public');
        }
        $instructor = auth()->guard('instructor')->user();
        $validated['instructor_id'] = $instructor->id;

        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();

        Course::create($validated);

        return redirect()->route('courses.instructorcourse')->with('success', 'Course created successfully!');
    }


    public function commissionReport()
    {
        $payments = Payment::with(['cart.user', 'cart.items.course.instructor'])->get();

        $commissions = $payments->flatMap(function ($payment) {
            return $payment->cart->items->map(function ($item) use ($payment) {
                return [
                    'order_id'   => $payment->id,
                    'customer'   => $payment->cart->user->first_name,
                    'type'       => 'Student',
                    'date'       => $payment->created_at->format('d M Y'),
                    'status'     => ucfirst($payment->state),
                    'commission' => number_format($payment->amount * 0.5, 2),
                ];
            });
        });

        $totalCommission    = number_format($payments->sum('amount') * 0.5, 2);
        $receivedCommission = number_format($payments->where('state', 'received')->sum('amount') * 0.5, 2);
        $pendingCommission  = number_format($payments->where('state', 'pending')->sum('amount') * 0.5, 2);

        return view('courses.commission', compact(
            'commissions',
            'totalCommission',
            'receivedCommission',
            'pendingCommission'
        ));
    }


public function reviews()
{
    $instructor = auth()->guard('instructor')->user();

    if (!$instructor) {
        abort(403, 'Unauthorized');
    }

    $courseIds = $instructor->courses->pluck('id');

    $reviews = Review::with(['user', 'reviewable'])
        ->where('reviewable_type', Course::class)
        ->whereIn('reviewable_id', $courseIds)
        ->latest()
        ->paginate(5);

    $starCounts = [
        1 => Review::where('reviewable_type', Course::class)->whereIn('reviewable_id', $courseIds)->where('rating', 1)->count(),
        2 => Review::where('reviewable_type', Course::class)->whereIn('reviewable_id', $courseIds)->where('rating', 2)->count(),
        3 => Review::where('reviewable_type', Course::class)->whereIn('reviewable_id', $courseIds)->where('rating', 3)->count(),
        4 => Review::where('reviewable_type', Course::class)->whereIn('reviewable_id', $courseIds)->where('rating', 4)->count(),
        5 => Review::where('reviewable_type', Course::class)->whereIn('reviewable_id', $courseIds)->where('rating', 5)->count(),
    ];

    $totalReviews = array_sum($starCounts);

    return view('courses.reviews', compact('reviews', 'starCounts', 'totalReviews'));
}


    
public function customers()
{
    $users = User::with(['enrollments.course']) 
        ->get()
        ->map(function ($user) {
            $payments = Payment::whereHas('cart', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->orderByDesc('created_at')->get();

            $lastPayment = $payments->first();
            $totalAmount = $payments->sum('amount');

            return [
                'id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'type' => 'Student',
                'country' => $lastPayment->country ?? 'N/A',
                'joined' => $user->created_at->toDateString(),
                'total_amount' => $totalAmount,
                'last_order' => optional($lastPayment)->created_at?->toDateString() ?? 'N/A',
                'order_id' => $lastPayment->id ?? 'N/A',
            ];
        });

    return view('courses.customer', compact('users'));
}



public function chapter()
    {
        $instructor = auth()->guard('instructor')->user();

        $chapters = Syllabus::with('course') // علشان نجيب السعر
            ->whereHas('course', function ($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })
            ->get();

        return view('courses.chapter', compact('chapters'));
    }

    public function chapterdetails($id)
    {
        $chapter = Syllabus::with('course')->findOrFail($id);
        $instructor = auth()->guard('instructor')->user();

        if ($chapter->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized');
        }

        return view('courses.chapterdetails', compact('chapter'));
    }

    public function destroy($id)
    {
        $chapter = Syllabus::findOrFail($id);

        $instructor = auth()->guard('instructor')->user();
        if ($chapter->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized');
        }

        $chapter->delete();

        return redirect()->route('chapter')->with('success', 'Chapter deleted successfully.');
    }


        
    public function toggleStatus($id)
    {
        $chapter = Syllabus::findOrFail($id);
        $instructor = auth()->guard('instructor')->user();

        if ($chapter->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized');
        }

        $chapter->status = $chapter->status === 'published' ? 'draft' : 'published';
        $chapter->save();

        return redirect()->back()->with('success', 'Chapter status updated to ' . $chapter->status . '.');
    }


}
