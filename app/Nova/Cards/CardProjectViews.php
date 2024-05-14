<?php

namespace App\Nova\Cards;

use App\Models\ProjectView;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Nova;
use Mako\CustomTableCard\Table\Cell;
use Mako\CustomTableCard\Table\Row;

class CardProjectViews extends \Mako\CustomTableCard\CustomTableCard
{

    public $width = '1/2';

    public function __construct()
    {
        $header = collect(['Porject #', 'Project Name', 'Deadline']);

        $this->title('Recently Viewed');
        $this->viewall(['label' => 'View All', 'link' => Nova::path() . '/resources/project-views']);
        // Get Project Views
        $projectViews = ProjectView::where('project_views.user_id', Auth::user()->id)  
            ->select('project_views.*','projects.id','projects.*')
            ->leftJoin('projects', 'project_views.project_id', '=', 'projects.id')
            ->orderBy('project_views.viewed_at', "DESC")
            ->paginate(7);

        $this->header($header->map(function($value) {
            return new Cell($value);
        })->toArray());

        $this->data($projectViews->map(function($model) {
            return new Row(
                new Cell('<a href="' . Nova::path() . '/resources/projects/' . $model->project_id . '" style="color: inherit; text-decoration: inherit;">' . $model->project_number . '</a>'),
                new Cell('<a href="' . Nova::path() . '/resources/projects/' . $model->project_id . '" style="color: inherit; text-decoration: inherit;">' . $model->name . '</a>'),
                // Instead of alphabetically ordering the status, set a sortableData value for better representation
                new Cell((new Carbon($model->deadline_date))->format('M d, Y'))
            );
        })->toArray());
    }

}