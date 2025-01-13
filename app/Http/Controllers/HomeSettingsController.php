<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomePageSettings;
use App\Models\Review;
use Illuminate\Support\Facades\File;  // Gunakan File
use Illuminate\Support\Facades\Storage;  // Gunakan Storage untuk move

class HomeSettingsController extends Controller
{
    public function index()
    {
        $settings = HomePageSettings::first();
        $reviews = Review::orderBy('created_at', 'desc')->get();
        return view('admin.settings.index', compact('settings', 'reviews'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_description' => 'required|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about_title' => 'required|string|max:255',
            'about_description' => 'required|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'services_title' => 'required|string|max:255',
            'services_description' => 'required|string',
            'suppliers_title' => 'required|string|max:255',
            'suppliers_description' => 'required|string',
        ]);

        $settings = HomePageSettings::first();

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            // Check if old image exists and delete it
            if ($settings->hero_image && File::exists(public_path('homepage/' . $settings->hero_image))) {
                File::delete(public_path('homepage/' . $settings->hero_image));
            }
            
            // Move the new image to public directory
            $heroImage = $request->file('hero_image');
            $heroImagePath = 'homepage/' . $heroImage->getClientOriginalName();
            $heroImage->move(public_path('homepage'), $heroImagePath);
            $settings->hero_image = $heroImagePath;
        }

        // Handle about image upload
        if ($request->hasFile('about_image')) {
            // Check if old image exists and delete it
            if ($settings->about_image && File::exists(public_path('homepage/' . $settings->about_image))) {
                File::delete(public_path('homepage/' . $settings->about_image));
            }
            
            // Move the new image to public directory
            $aboutImage = $request->file('about_image');
            $aboutImagePath = 'homepage/' . $aboutImage->getClientOriginalName();
            $aboutImage->move(public_path('homepage'), $aboutImagePath);
            $settings->about_image = $aboutImagePath;
        }

        // Update other settings
        $settings->update([
            'hero_title' => $validated['hero_title'],
            'hero_description' => $validated['hero_description'],
            'about_title' => $validated['about_title'],
            'about_description' => $validated['about_description'],
            'services_title' => $validated['services_title'],
            'services_description' => $validated['services_description'],
            'suppliers_title' => $validated['suppliers_title'],
            'suppliers_description' => $validated['suppliers_description'],
        ]);

        return redirect()->back()->with('success', 'Homepage settings updated successfully.');
    }
}
