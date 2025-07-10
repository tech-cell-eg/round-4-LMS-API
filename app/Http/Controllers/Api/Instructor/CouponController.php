<?php

namespace App\Http\Controllers\Api\Instructor;

use Carbon\Carbon; 
use App\Models\User;
use App\Models\Coupon; 
use App\Models\Course; 
use App\Models\Instructor; 
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\Validation\Rule; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use App\Http\Resources\CouponResource;
use App\Http\Resources\CouponRedemptionResource;


class CouponController extends Controller
{
    // الدالة دي هي اللي هتجيب كل الكوبونات الخاصة بالـ Instructor الحالي
    // وتقوم بعرضها في صفحة لوحة التحكم 
    public function index(Request $request)
    {
        /** @var \App\Models\Instructor|null $instructor */
        $instructor = Auth::user();

        // جلب الكوبونات الخاصة بالـ Instructor ده فقط
        // Instructor hasMany coupons() relation, تأكد من وجودها في موديل Instructor
        $query = $instructor->coupons();

        // لو فيه بحث باسم الكوبون
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('coupon_name', 'like', '%' . $request->search . '%')
                  ->orWhere('coupon_code', 'like', '%' . $request->search . '%');
            });
        }

        // لو فيه فلترة بالحالة
        if ($request->has('status') && $request->status != 'all') {
            $query->where('coupon_status', $request->status);
        }

        // لو فيه فلترة بالتصنيف
        if ($request->has('category') && $request->category != 'all') {
            $query->where('coupon_category', $request->category);
        }

        // جلب الكوبونات مع تحميل علاقة 'course'
        // وإضافة 'redemptions_count' لحساب عدد مرات الاستخدام لكل كوبون
        $coupons = $query->with('course') 
                         ->withCount('redemptions') // بيحسب عدد مرات استخدام الكوبون
                         ->paginate(10); 

        // استخدام الـ CouponResource لـ Collection من الكوبونات
        return CouponResource::collection($coupons);
    }

    // الدالة دي هتستخدم لإنشاء كوبون جديد
    // وهتستقبل البيانات من الفورم اللي في صفحة "Create coupon" 
    public function store(Request $request)
    {
        // 1. التحقق من البيانات المرسلة (Validation)
        $validatedData = $request->validate([
            'coupon_status' => ['required', 'string', Rule::in(['draft', 'active', 'inactive', 'scheduled'])], // status ممكن تبقى draft في البداية
            'coupon_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'customer_group' => ['required', 'string', Rule::in(['general', 'specific_users'])],
            'coupon_category' => ['required', 'string', Rule::in(['specific_coupon', 'general_promotion'])],
            'coupon_code' => 'required|string|unique:coupons,coupon_code|alpha_dash|max:50', // unique في جدول coupons، alpha_dash يعني حروف وأرقام وشرط
            'uses_per_coupon' => 'nullable|integer|min:1',
            'uses_per_customer' => 'nullable|integer|min:1',
            'priority' => 'nullable|integer|min:0',
            'discount_type' => ['required', 'string', Rule::in(['percentage', 'fixed_amount'])],
            'discount_value' => 'required|numeric|min:0',
            'start_from' => 'required|date_format:Y-m-d',
            'end_at' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'course_id' => 'nullable|exists:courses,id', // الكورس لو تم إرساله لازم يكون موجود في جدول الكورسات
        ]);

        // 2. التحقق من صلاحية الـ Instructor
        $instructor = Auth::user();

        // 3. التحقق الإضافي: لو الكوبون مرتبط بكورس، نتأكد إن الكورس ده بتاع الـ Instructor الحالي
        if (isset($validatedData['course_id'])) {
            $course = Course::where('id', $validatedData['course_id'])
                            ->where('instructor_id', $instructor->id)
                            ->first();
            if (!$course) {
                return response()->json(['message' => 'The selected course does not belong to this instructor or does not exist.'], Response::HTTP_FORBIDDEN);
            }
        }

        // 4. إنشاء الكوبون في قاعدة البيانات
        $coupon = new Coupon($validatedData);
        $coupon->instructor_id = $instructor->id; // ربط الكوبون بالـ instructor_id بتاع الـ instructor اللي عمل login
        $coupon->save();

        // 5. إرجاع الـ Response باستخدام الـ Resource
        // Response::HTTP_CREATED (201) هو الـ Status Code المناسب لعمليات الإنشاء الناجحة
        return (new CouponResource($coupon))
                    ->response()
                    ->setStatusCode(Response::HTTP_CREATED);
    }

    // الدالة دي هتجيب تفاصيل كوبون واحد محدد
    // وهتعرضها في صفحة "Coupon details" 
   public function show(Request $request, Coupon $coupon)
    {
        /** @var \App\Models\Instructor|null $instructor */
        $instructor = Auth::user();

        // قم بتحميل عدد عمليات الاستخدام هنا
        $coupon->loadCount('redemptions');

        // قم بتحميل عمليات الاستخدام مع علاقة المستخدم (User) والكوبون (Coupon)
        // لأن CouponRedemptionResource تحتاج هذه العلاقات لعرض تفاصيل المستخدم والكوبون
        $redemptions = $coupon->redemptions()->with(['user', 'coupon'])->paginate(5); 

        return response()->json([
            'coupon' => new CouponResource($coupon), 
            'redemptions' => [
                'data' => CouponRedemptionResource::collection($redemptions->items()), 
                'pagination' => [
                    'total' => $redemptions->total(),
                    'per_page' => $redemptions->perPage(),
                    'current_page' => $redemptions->currentPage(),
                    'last_page' => $redemptions->lastPage(),
                    'next_page_url' => $redemptions->nextPageUrl(),
                    'prev_page_url' => $redemptions->previousPageUrl(),
                ],
            ],
        ]);
    }


    // الدالة دي هتستخدم لتعديل بيانات كوبون موجود
    // وهتستقبل البيانات من الفورم اللي في صفحة "Edit coupon" 
    public function update(Request $request, Coupon $coupon)
    {
        // 1. التحقق من صلاحية الـ Instructor
        $instructor = Auth::user();

        // 2. التأكد إن الكوبون ده تبع الـ Instructor اللي عامل login
        if ($coupon->instructor_id !== $instructor->id) {
            return response()->json(['message' => 'Forbidden: You do not have access to this coupon.'], Response::HTTP_FORBIDDEN);
        }

        // 3. التحقق من البيانات المرسلة (Validation)
        // هنا 'sometimes' rule عشان لو مش كل الحقول هيتم تعديلها
        $validatedData = $request->validate([
            'coupon_status' => ['sometimes', 'required', 'string', Rule::in(['draft', 'active', 'inactive', 'scheduled', 'expired'])],
            'coupon_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string', // nullable لأن ممكن يتحذف أو يتغير لـ null
            'customer_group' => ['sometimes', 'required', 'string', Rule::in(['general', 'specific_users'])],
            'coupon_category' => ['sometimes', 'required', 'string', Rule::in(['specific_coupon', 'general_promotion'])],
            'coupon_code' => [
                'sometimes',
                'required',
                'string',
                Rule::unique('coupons', 'coupon_code')->ignore($coupon->id), // مهم: تجاهل الـ id بتاع الكوبون الحالي
                'alpha_dash',
                'max:50'
            ],
            'uses_per_coupon' => 'nullable|integer|min:1',
            'uses_per_customer' => 'nullable|integer|min:1',
            'priority' => 'nullable|integer|min:0',
            'discount_type' => ['sometimes', 'required', 'string', Rule::in(['percentage', 'fixed_amount'])],
            'discount_value' => 'sometimes|required|numeric|min:0',
            'start_date' => 'sometimes|required|date_format:Y-m-d',
            'start_time' => 'sometimes|required|date_format:H:i:s',
            'end_date' => 'sometimes|required|date_format:Y-m-d|after_or_equal:start_date',
            'end_time' => 'sometimes|required|date_format:H:i:s',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        // 4. التحقق الإضافي: لو الكوبون مرتبط بكورس، نتأكد إن الكورس ده بتاع الـ Instructor الحالي
        if (isset($validatedData['course_id'])) {
            $course = Course::where('id', $validatedData['course_id'])
                            ->where('instructor_id', $instructor->id)
                            ->first();
            if (!$course) {
                return response()->json(['message' => 'The selected course does not belong to this instructor or does not exist.'], Response::HTTP_FORBIDDEN);
            }
        } elseif (array_key_exists('course_id', $validatedData) && $validatedData['course_id'] === null) {
            // لو الـ frontend بعت course_id: null عشان يشيل الربط
            // لا حاجة لعمل شيء، لأنه already nullable
        }


        // 5. تحديث بيانات الكوبون
        $coupon->update($validatedData);

        // 6. إرجاع الـ Response
        return new CouponResource($coupon);
    }

    // الدالة دي هتستخدم لحذف كوبون
    public function destroy(Request $request, Coupon $coupon)
    {
        // 1. التحقق من صلاحية الـ Instructor
        $instructor = Auth::user();

        // 2. التأكد إن الكوبون ده تبع الـ Instructor اللي عامل login
        if ($coupon->instructor_id !== $instructor->id) {
            return response()->json(['message' => 'Forbidden: You do not have access to delete this coupon.'], Response::HTTP_FORBIDDEN);
        }

        // 3. حذف الكوبون
        $coupon->delete();

        // 4. إرجاع Response بنجاح الحذف
        return response()->json(['message' => 'Coupon deleted successfully.'], Response::HTTP_NO_CONTENT); // 204 No Content مناسب للحذف
    }
}