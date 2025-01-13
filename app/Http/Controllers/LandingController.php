<?php

namespace App\Http\Controllers;

use App\Models\HomePageSettings;
use App\Models\JenisLaundry;
use App\Models\Review;
use App\Models\Supplier;
use App\Models\Karyawan;
use App\Models\TarifLaundry;
use App\Models\LayananTambahan;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the landing page with all necessary data
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Fetch homepage settings
            $settings = HomePageSettings::firstOrFail();

            // Fetch active services (JenisLaundry)
            $services = JenisLaundry::select([
                'id_jenis',
                'nama_jenis',
                'deskripsi',
                'gambar'
            ])->limit(3)->get();

            // Fetch recent reviews with high ratings
            $reviews = Review::select([
                'name',
                'rating',
                'message'
            ])
            ->where('is_displayed', true) // Tambahkan kondisi is_displayed true
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();


            // Fetch active suppliers
            $suppliers = Supplier::select([
                'id_supplier',
                'nama_supplier'
            ])->get();

            // Return view with all necessary data
            return view('landing.index', compact(
                'settings',
                'services',
                'reviews',
                'suppliers'
            ));

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in landing page: ' . $e->getMessage());

            // Return error view or redirect with error message
            return redirect()
                ->route('error')
                ->with('error', 'Unable to load the page. Please try again later.');
        }
    }

    /**
     * Handle review submission
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitReview(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'nameForm' => 'required|string|max:255',
                'emailForm' => 'required|email|max:255',
                'ratingForm' => 'required|integer|min:1|max:5',
                'messageForm' => 'required|string|max:1000',
            ]);

            // Create new review
            Review::create([
                'name' => $validated['nameForm'],
                'email' => $validated['emailForm'],
                'rating' => $validated['ratingForm'],
                'message' => $validated['messageForm'],
                'is_displayed' => false,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Thank you for your review!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Error submitting review: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while submitting your review.'
            ], 500);
        }
    }

    public function about()
    {
        $karyawans = Karyawan::all();
        return view('landing.about', compact('karyawans'));
    }

    public function services()
    {
        try {
            // Fetch jenis laundry with their tariffs
            $jenisLaundry = JenisLaundry::with('tarif')->get();

            // Fetch tarif laundry grouped by jenis_tarif
            $tarifPerKilo = TarifLaundry::where('jenis_tarif', 'satuan')
                ->with('jenisLaundry')
                ->get();
                
            $tarifSatuan = TarifLaundry::where('jenis_tarif', 'jenis pakaian')
                ->with('jenisLaundry')
                ->get();

            // Fetch active layanan tambahan
            $layananTambahan = LayananTambahan::where('status', 'Aktif')->get();

            return view('landing.services', compact(
                'jenisLaundry',
                'tarifPerKilo',
                'tarifSatuan',
                'layananTambahan'
            ));

        } catch (\Exception $e) {
            \Log::error('Error in services page: ' . $e->getMessage());
            
            return redirect()
                ->route('landing')
                ->with('error', 'Unable to load services. Please try again later.');
        }
    }
}