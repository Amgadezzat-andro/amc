<?php

namespace App\Http\Controllers;

use App\Filament\Resources\Project\Model\Project;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function index()
    {
        $data['projects'] = Cache::remember('projects_list', 300, function () {
            return Project::active()
                ->with(['mainImage'])
                ->orderBy('weight_order')
                ->orderByDesc('published_at')
                ->get();
        });

        return view('projects.index', $data);
    }

    public function view($locale, $slug)
    {
        $project = Project::active()
            ->with(['mainImage'])
            ->where('slug', $slug)
            ->firstOrFail();
        return view('projects.view', ['project' => $project]);
    }
}
