<?php

namespace App\Nova\Cards;

use App\Models\ProjectFavorite;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Nova;
use Mako\CustomTableCard\Table\Cell;
use Mako\CustomTableCard\Table\Row;

class CardProjectFavorites extends \Mako\CustomTableCard\CustomTableCard
{

    public $width = '1/2';

    public function __construct()
    {
        $header = collect(['Porject #', 'Project Name', 'Deadline']);

        $this->title('Favorited Projects');
        $this->viewall(['label' => 'View All', 'link' => Nova::path() . '/resources/project-favorites']);
        // Get Project Favorites
        $projectFavorites = ProjectFavorite::where([
                ['project_favorites.user_id', '=', Auth::user()->id]
            ])
            ->whereNotNull('projects.id')
            ->select('project_favorites.*','projects.id','projects.*')
            ->leftJoin('projects', 'project_favorites.project_id', '=', 'projects.id')
            ->orderBy('project_favorites.created_at', "DESC")
            ->paginate(7);

        $this->header($header->map(function($value) {
            return new Cell($value);
        })->toArray());
        $this->data($projectFavorites->map(function($model) {
            return new Row(
                new Cell('<a href="' . Nova::path() . '/resources/projects/' . $model['project']["id"] . '" style="color: inherit; text-decoration: inherit;">' . $model['project']['project_number'] . '</a>'),
                new Cell('<a href="' . Nova::path() . '/resources/projects/' . $model['project']["id"] . '" style="color: inherit; text-decoration: inherit;">' . $model['project']['name'] . '</a>'),
                // Instead of alphabetically ordering the status, set a sortableData value for better representation
                new Cell($model['project']['deadline_onlydate'])
            );
        })->toArray());
    }
    
}