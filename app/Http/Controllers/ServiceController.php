<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Services/Index', [
            'services' => Service::query()
                ->when($request->search, function ($query, $search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($service) => [
                    'id' => $service->id,
                    'name' => $service->name,
                    'image_path' => $service->image_path,
                    'description' => substr($service->description, 0, 50).'...',
                ]),
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Services/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|max:2048|mimes:png,jpg,jpeg',
            'description' => 'required',
        ]);

        $imageName = now()->format('YmdHis').'-'.time().'.'.$request->file('image')->getClientOriginalExtension();
        $imagePath = $request->file('image')->storeAs('services', $imageName, 'public');

        Service::create([
            'name' => $request->name,
            'image_path' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('services.index')->with('alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Service created successfully',
        ]);
    }

    public function edit(Service $service)
    {
        return Inertia::render('Services/Edit', [
            'service' => [
                'id' => $service->id,
                'name' => $service->name,
                'image_path' => $service->image_path,
                'description' => $service->description,
            ],
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|max:2048|mimes:png,jpg,jpeg',
            'description' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $imageName = now()->format('YmdHis').'-'.time().'.'.$request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('services', $imageName, 'public');
        } else {
            $imagePath = $service->image_path;
        }

        $service->update([
            'name' => $request->name,
            'image_path' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('services.index')->with('alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Service updated successfully',
        ]);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Service deleted successfully',
        ]);
    }
}
