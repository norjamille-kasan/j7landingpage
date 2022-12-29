<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Projects/Index', [
            'projects' => Project::query()
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
        return Inertia::render('Projects/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|max:2048|mimes:png,jpg,jpeg',
            'description' => 'required',
        ]);

        $imageName = now()->format('YmdHis').'-'.time().'.'.$request->file('image')->getClientOriginalExtension();
        $imagePath = $request->file('image')->storeAs('projects', $imageName, 'public');

        Project::create([
            'name' => $request->name,
            'image_path' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('projects.index')->with('alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Project created successfully',
        ]);
    }

    public function edit(Project $project)
    {
        return Inertia::render('Projects/Edit', [
            'project' => [
                'id' => $project->id,
                'name' => $project->name,
                'image_path' => $project->image_path,
                'description' => $project->description,
            ],
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|max:2048|mimes:png,jpg,jpeg',
            'description' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $imageName = now()->format('YmdHis').'-'.time().'.'.$request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('projects', $imageName, 'public');
        } else {
            $imagePath = $project->image_path;
        }

        $project->update([
            'name' => $request->name,
            'image_path' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('projects.index')->with('alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Project updated successfully',
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Project deleted successfully',
        ]);
    }
}
