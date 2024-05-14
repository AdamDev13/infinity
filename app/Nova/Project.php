<?php

namespace App\Nova;

use App\Events\UserFavoriteProjectEvent;
use App\Models\Category;
use App\Models\ProjectFavorite;
use App\Models\ProjectView;
use App\Models\Timezone as ModelsTimezone;
use App\Nova\Actions\ProjectBidExport;
use App\Nova\Filters\County;
use App\Nova\Filters\DueBy;
use App\Nova\Filters\UsaState;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Panel;

use App\Nova\Actions\FavoriteProject;
use App\Nova\Traits\PagePerOptionTrait;
use Laraning\NovaTimeField\TimeField;
use NovaButton\Button;
use OptimistDigital\NovaDetachedFilters\NovaDetachedFilters;
use Pdmfc\NovaFields\ActionButton;
use Yassi\NestedForm\NestedForm;
use KirschbaumDevelopment\NovaComments\Commenter;
use KirschbaumDevelopment\NovaComments\CommentsPanel;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;


class Project extends Resource
{
    use PagePerOptionTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Project::class;

    /**
     * Display resource in navigation.
     *
     * @var boolean
     */
    public static $displayInNavigation = false;


    /**
     * Display resource in navigation.
     *
     * @var boolean
     */
    public static $tableStyle = 'default';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'project_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'project_number', 'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            (new Panel('Project Admin', [
                BelongsTo::make('Admin Name', 'belongsToAdmin', '\App\Nova\Admin')->withMeta([
                    'belongsToId' => Auth::user()->id,
                    'extraAttributes' => [
                        'readonly' => false
                    ]])->display(function ($user) {
                    return $user->name;
                })->hideFromIndex()->showOnCreating()
            ])),
//            HasOne::make('Admin', 'admin', 'App\Nova\Admin'),
            (new Panel('Client Details', [
                BelongsTo::make('Client Name', 'userBelongs', '\App\Nova\Client')
                    ->withMeta(['extraAttributes' => [
                        'readonly' => false,
                    ]])
                    ->display(function ($user) {
                        return $user->fullDetails;
                    })
                    ->hideFromIndex()
            ])),

            HasOne::make('Client Details', 'user', 'App\Nova\Client'),

            (new Panel('Project Details', [
                $this->buttonFavorite($this->id),

                Text::make('Project #', 'project_number')
                    ->sortable()
                    ->rules('required', 'max:255'),
                Text::make('Project Name', 'name')
                    ->detailLink()
                    ->sortable()
                    ->rules('required', 'max:255'),
                Select::make('Category', 'category_id')
                    ->options(function () {
                        return array_filter(Category::pluck('name', 'id')->toArray());
                    })
                    ->rules('required')
                    ->displayUsingLabels()
                    ->sortable(),
                BelongsTo::make('Client', 'userBelongs', '\App\Nova\Client')
                    ->withMeta(['extraAttributes' => [
                        'readonly' => false,
                    ]])
                    ->display(function ($user) {
                        return $user->fullDetails;
                    })
                    ->onlyOnIndex()
                    ->viewable(false),
                Markdown::make('Description', 'description')
                    ->alwaysShow()
                    ->rules('max:65000')
            ])),

            (new Panel('Deadline Date', [
                Date::make('Deadline Date', 'deadline_date')
                    ->format("ll")
                    ->rules('required')
                    ->sortable(),
                TimeField::make('Deadline Time', 'deadline_time')
                    ->withTwelveHourTime()
//                    ->format('H:i:s')
//                    ->withTimezoneAdjustments()
                    ->rules('required')
                    ->hideFromIndex(),
                // deadline time 5pm
                // pacific
                Select::make('Project Timezone', 'timezone')
                    ->options(function () {
                        return array_filter(ModelsTimezone::USA());
                    })
                    ->displayUsingLabels()
                    ->rules('required')
                    ->hideFromIndex(),
                Boolean::make('Walkthrough? ( Mark If the project has walk-through data )', 'walkthrough')
                    ->trueValue(1)
                    ->falseValue(0)
                    ->rules('nullable', 'bool')
                    ->hideFromIndex()
                    ->hideFromDetail(),
                Text::make('Walkthrough', function () {
                    return ($this->walkthrough > 0) ? '<span style="background-color:#21b978; padding:3px 20px; border-radius:12px; color:#fff; letter-spacing:1px;">Yes</span>' : '<span style="background-color:#e74444; padding:3px 20px; border-radius:12px; color:#fff; letter-spacing:1px;">No</span>';
                })
                    ->asHtml()
                    ->onlyOnDetail(call_user_func(function () {
//                        ProjectView::create([
//                            "user_id" => Auth::user()->id,
//                            "project_id" => $this->resourceId,
//                        ]);
                    })),
            ])),
            (new Panel('RFP Files', [
                NestedForm::make('projectrfpfile')
                    ->open(true)
                    ->heading(__('RFP File'))
                    ->max(5),
            ])),
            NestedForm::make('projectaddendum')
                ->open(true)
                ->heading(__('Addendum File:'))
                ->max(5),

            (new Panel('Files', [
                HasMany::make('Project RFP Files', 'projectrfpfileASCOrder', 'App\Nova\ProjectRfpFile'),
                HasMany::make('Project Addendum Files', 'projectaddendumASCOrder', 'App\Nova\ProjectAddendum'),

            ])),
            (new Panel('Project Bid Submission', [
                HasMany::make('Project Bids', 'bids', 'App\Nova\ProjectBid'),
            ]))->withToolbar(),
            (new Panel('Ask A Question', [
                HasMany::make('Project Question', 'questions', 'App\Nova\ProjectQuestion'),
            ])),
            ActionButton::make('Favorite?')
                ->action(FavoriteProject::class, $this->id)
                ->text('❤')
                ->showLoadingAnimation()
                ->onlyOnIndex()
                ->buttonColor(call_user_func(function () {
                    $ProjectFavorite = ProjectFavorite::where("user_id", Auth::user()->id)
                        ->where("project_id", $this->id)->first();
                    return ($ProjectFavorite && $ProjectFavorite->status == "active") ? '#6A23CE' : '#e6d7fc';
                }))
                ->canSee(function () {
                    return Auth::user()->hasRole(['vendor']);
                }),

            HasMany::make('Project Views', 'viewers', 'App\Nova\ProjectView')
                ->canSee(function ($request) {
                    return Auth::user()->hasRole(['superadmin', 'admin']);
                }),

            HasMany::make('Project Logs', 'logs', 'App\Nova\ProjectLog')
                ->canSee(function ($request) {
                    return Auth::user()->hasRole(['superadmin', 'admin']);
                }),
            Date::make('Public Date', 'public_date')
                ->format("ll")
                ->rules('required')
                ->sortable(),
//            BelongsTo::make('Project Admin', 'userBelongs', '\App\Nova\Admin')
//                ->display(function($user) {
//                    return $user->fullDetails;
//                })


        ];
    }

    public function buttonFavorite($project_id)
    {
        $ProjectFavorite = ProjectFavorite::where("user_id", Auth::user()->id)
            ->where("project_id", $project_id)->first();
        // is primary
        $text = "Add to ❤ Favorites";
        $style = "grey-outline";
        $successText = "❤ Favorited";
        $successStyle = "primary";
        if ($ProjectFavorite && $ProjectFavorite->status == "active") {
            $text = "❤ Favorited";
            $style = "primary";
            $successText = "Add to ❤ Favorites";
            $successStyle = "grey-outline";
        }

        return Button::make($text)
            ->style($style)
            ->loadingText("working...")
            ->loadingStyle('grey-outline')
            ->successText($successText)
            ->successStyle($successStyle)
            ->reload(true)
            ->event(UserFavoriteProjectEvent::class)
            ->onlyOnDetail();
    }

    public function logView($project_id)
    {
        if (Auth::user()->hasPermissionTo('vendor')) {
            ProjectView::firstOrCreate([
                "user_id" => Auth::user()->id,
                "project_id" => $project_id,
            ]);
        }
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            (new NovaDetachedFilters($this->myFilters()))->width("full")
            //    (new Infoclient)->currentClient(),
        ];
    }


    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return $this->myFilters();
    }

    protected function myFilters()
    {
        return [
            UsaState::make(),
            County::make(),
            new Filters\DueBy,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
//        dd(base64_decode($request->filters));
        if ($request->resourceId) {
            $project_id = $request->resourceId;
            $this->logView($project_id);
        }
        return [
            // Favorite the Project
//            FavoriteProject::make()
//            ->withoutConfirmation()

            (new FavoriteProject())
                ->canSee(function ($request) {
                    return Auth::user()->hasPermissionTo('vendor');
                })->canRun(function ($request) {
                    return Auth::user()->hasPermissionTo('vendor');
                })->onlyOnIndex()

            /*
            FavoriteProject::make()
            ->canSee(function ($request) {
                return Auth::user()->hasRole(['vendor']);
            })->canRun(function ($request) {
                return Auth::user()->hasRole(['vendor']);
            })->onlyOnIndex()
            ->confirmText('Favorite / Unfavorite?')
            ->confirmButtonText('Go')
            ->cancelButtonText("Cancel"),
*/
        ];
    }

    /**
     * Handle the Project "view" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function view()
    {
        //    ProjectView::create([
        //        "project_id" => $this->id,
        //        "user_id" => Auth::user()->id()
        //    ]);
    }

    public static function updateButtonLabel()
    {
        return 'Update & Email';
    }

    public static function indexQuery(NovaRequest $request, $query)
    {

        if ($request->isCreateOrAttachRequest() || $request->isUpdateOrUpdateAttachedRequest()) {
            return $query;
        }


        $isQueryExpired = false;
        $filters = json_decode(base64_decode($request->get('filters', '{}')));
        if (!empty($filters) && is_array($filters)) {
            foreach ($filters as $filter) {
                if ($filter->class === DueBy::class) {
                    if ($filter->value === '20' || $filter->value === '0') {
                        $isQueryExpired = true;
                    }
                }
            }
        }

        if ($request->viaResource == "clients" && $request->relationshipType == "hasMany") {
            if (Auth::user()->hasRole('admin')) {
                $isQueryExpired = true;
            }
        }

        if (!$isQueryExpired) {
            return $query
                ->where("public_date", "<=", date("Y-m-d h:i:s"))
                ->where("deadline_date", ">=", date("Y-m-d"))
                ->whereRaw('DATE_ADD(deadline_date, INTERVAL deadline_beyond DAY)')
                ->get();
        }
    }

//    /**
//     * Authorize to Delete
//     *
//     * @return true if role is matched
//     */
//    public function authorizedToDelete(Request $request)
//    {
//        return (Auth::user()->hasRole(["superadmin"])) ? true : false;
//    }

//    /**
//     * Authorize to Update
//     *
//     * @return bool true if role is matched
//     */
//    public function authorizedToUpdate(Request $request)
//    {
//        return (Auth::user()->hasRole(["superadmin"])) ? true : false;
//    }

    public function allProject(NovaRequest $request, $query)
    {
        return $query->get();
    }

}
