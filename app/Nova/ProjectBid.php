<?php

namespace App\Nova;

use App\Models\Project;
use App\Models\ProjectFavorite;
use App\Nova\Actions\FavoriteProject;
use App\Nova\Actions\ProjectBidExport;
use App\Nova\Actions\ProjectBidWidthdraw;
use App\Nova\Traits\PagePerOptionTrait;
use Carbon\Carbon;
use Codebykyle\CalculatedField\BroadcasterField;
use Codebykyle\CalculatedField\ListenerField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Dropzone;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use Nette\Utils\Floats;
use Pdmfc\NovaFields\ActionButton;
use function PHPUnit\Framework\isNull;

class ProjectBid extends Resource
{
    use PagePerOptionTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ProjectBid::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */

    public static function searchable()
    {
        return false;
    }

    public static $search = [
        'id',
    ];

    public static function label()
    {
        return "Project Bid Submission";
    }

    public static function singularLabel()
    {
        return 'Project Bid Submission';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            BelongsTo::make('Project')
                ->withMeta(['extraAttributes' => [
                    'readonly' => false,
                ]])
                ->display(function ($model) {
                    return $model->name;
                }),
//            BelongsTo::make('User')->nullable(),
            BelongsTo::make(__('Company'), 'userBelongs', '\App\Nova\Vendor')
                ->withMeta(['extraAttributes' => [
                    'readonly' => false,
                ]])
                ->display(function ($model) {
                    return $model->name;
                }),
            Hidden::make('user_id')->default(Auth::id()),

            Text::make(__('Name of File'), 'label')
                ->rules('required', 'max:255')
                ->hideFromIndex($this->projectDeadlinePassedForListingPage())
                ->hideFromDetail($this->projectDeadlinePassed()),

            Dropzone::make(__('Url'), 'url')
                ->disk('s3')
                ->path('bids')
                ->creationRules('required')
                ->onlyOnForms()
                ->hideFromIndex()
                ->hideFromDetail(),

            Text::make(__('Click any file to download'), function ($model) {

                return '<a href="' . $model->file_url . '" style="font-size:16px; text-decoration: none;" target="_blank"><img style="position:relative; top:2px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAABmJLR0QA/wD/AP+gvaeTAAAA8ElEQVQ4jc3TLU4DQRjG8R8UECiOUcGGSpriIOEACD4SHMGh4AAcoaaWBNUKDCeAAyAIIHoLFBCShSB2l0ynDTtLEDxq8uZ5/jPvvDP8keYa+nvYiGrXGC80BL3guVyv4gQfGDfkfKuNB/RxBuGJDrGNpRnBdxzjDRmG2MM6VkLQFg5wjnwGKI8g+3gqQRM6xVFNO1kZzoJaB93wRHXTyzBStPOIZbzivjLM1wAophNCOhjEppTxt7GraKvKTOVSQFcJnqTWkvR/QTlaiZmW4n9NqLrsW1yU4ClTpB1cxsXwIa5hE4s/QD5xh5uazX6vL5j+Jo2wFztXAAAAAElFTkSuQmCC"/> Download File</a>';
            })
                ->help("Must include http or https")
                ->rules('required', 'max:255')
                ->asHtml()
                ->hideFromIndex($this->projectDeadlinePassedForListingPage())
                ->hideFromDetail($this->projectDeadlinePassed()),

            BroadcasterField::make(__('Base Price'), 'base_price')
                ->hideFromIndex($this->projectDeadlinePassedForListingPage())
                ->hideFromDetail($this->projectDeadlinePassed() && $this->isCategory1())
                ->required(),

            BroadcasterField::make(__("Contingency Fee"), 'contingency_fee')
                ->hideFromIndex($this->projectDeadlinePassedForListingPage())
                ->hideFromDetail($this->projectDeadlinePassed() && $this->isCategory1())
                ->required(),

            ListenerField::make('Total', 'total')
                ->hideFromIndex($this->projectDeadlinePassedForListingPage())
                ->hideFromDetail($this->projectDeadlinePassed() && $this->isCategory1())
                ->calculateWith(function (Collection $values) {
                    $basePrice = $values->get('base_price');
                    $contingencyFee = $values->get('contingency_fee');
                    return $basePrice + $contingencyFee;
                })->withMeta(['readonly' => true])->readonly(true),

            BroadcasterField::make(__('Monthly cost'), 'monthly_cost')
                ->hideFromIndex($this->projectDeadlinePassedForListingPage())
                ->hideFromDetail($this->projectDeadlinePassed() && !$this->isCategory1())
                ->required(),

            BroadcasterField::make(__("Monthly Tax Cost"), 'monthly_tax_cost')
                ->hideFromIndex($this->projectDeadlinePassedForListingPage())
                ->hideFromDetail($this->projectDeadlinePassed() && !$this->isCategory1())
                ->required(),

            BroadcasterField::make(__("Non Recurring Cost"), 'non_recurring_cost')
                ->hideFromIndex($this->projectDeadlinePassedForListingPage())
                ->hideFromDetail($this->projectDeadlinePassed() && !$this->isCategory1())
                ->required(),

            ListenerField::make('Total', 'total')
                ->hideFromIndex($this->projectDeadlinePassedForListingPage() && !$this->isCategory1())
                ->hideFromDetail(true)
                ->calculateWith(function (Collection $values) {
                    return $values->get('monthly_cost') + $values->get('monthly_tax_cost') + $values->get('non_recurring_cost');
                })->withMeta(['readonly' => true])->readonly(true),


            Select::make('status')->options([
                'RE' => 'Recommended',
                'R' => 'Rejected',
                'L' => 'Late Bid',
                'A' => 'Active',
            ])->canSee(function ($request) {
                return Auth::user()->hasRole(['superadmin', 'admin']);
            })->displayUsingLabels()
                ->hideFromIndex($this->projectDeadlinePassedForListingPage())
                ->hideFromDetail($this->projectDeadlinePassed()),

            Textarea::make('note')
                ->nullable()
                ->canSee(function ($request) {
                    return Auth::user()->hasRole(['superadmin', 'admin']);
                })->hideFromIndex($this->projectDeadlinePassedForListingPage())
                ->hideFromDetail($this->projectDeadlinePassed()),
            Text::make('is_withdraw', function () {
                return ($this->is_withdraw > 0) ? '<span style="background-color:#21b978; padding:3px 20px; border-radius:12px; color:#fff; letter-spacing:1px;">Yes</span>' : '<span></span>';
            })
                ->asHtml()
//                ->withMeta(['extraAttributes' => [
//                    'readonly' => true,
//                ]])
                ->canSee(function ($request) {
                    return Auth::user()->hasRole(['superadmin', 'admin']);
                }),
            Text::make("Submitted At", 'created_at', function () {
                if ($this->status == "L") {
                    return "<span class='text-danger'>" . $this->created_at->format("m/d/Y g:i:s A T") . "</span>";
                }
                if (!$this->created_at) {
                    return "";
                }
                return "<span>" . $this->created_at->format("m/d/Y g:i:s A T") . "</span>";
            })
                ->asHtml()
                ->hideWhenCreating()
                ->hideWhenUpdating()

            ,

            ActionButton::make('WithDraw?')
                ->action(ProjectBidWidthdraw::class, $this->id)
                ->text('Withdraw')
                ->showLoadingAnimation()
                ->onlyOnIndex()
                ->buttonColor(call_user_func(function () {
                    return '#f05b4f';
                }))
                ->canSee(function () {
                    return Auth::user()->hasRole(['vendor']);
                }),

            (new Panel('Files', [
                HasMany::make('Project Bid Files', 'attachments', 'App\Nova\ProjectBidAttachment'),
            ])),
        ];
    }


    public function projectDeadlinePassed()
    {
        if (!$this->project) {
            return true;
        }

        $deadline = $this->project->deadline_datetime;
        if (!isNull($deadline) && Carbon::now()->gt($deadline)) {
            return true;
        }
        return false;
    }

    public function isCategory1()
    {
        if (!$this->project) {
            return false;
        }

        return $this->project->isCategory1;
    }

    public function projectDeadlinePassedForListingPage()
    {
        if (Auth::user()->hasRole('vendor')) {
            return false;
        }
        return true;
    }

    public function projectDeadlinePassedModel($model)
    {
        $deadline = $model->project->deadline_datetime;
        if (!isNull($deadline) && Carbon::now()->gt($deadline)) {
            return true;
        }
        return false;
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
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
        return [
            (new Actions\ProjectBidWidthdraw())->canRun(function (Request $request) {
                return true;
            })->canSee(function (Request $request) {
                return (bool)$request->user()->hasRole("vendor");
            }),
            ((new ProjectBidExport())
                ->askForFilename()
                ->askForWriterType())
                ->canRun(function (Request $request, $model) {
                    return true;
                })
                ->canSee(function (Request $request) {
                    if ($this->resource instanceof Model) {
                        return $request->user()->can('download', $this->resource);
                    }
//                    if (!$request->user()->hasRole(['superadmin', 'admin'])) {
////                        return $this->projectDeadlinePassed();
//                        return false;
//                    }
                    return false;
                })


        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        $whereClause = [];
        // if Vendor > only return Vendor Project Views
        if (Auth::user()->hasRole(['vendor'])) {
            $whereClause[] = ['project_bids.user_id', '=', Auth::user()->id];
            $whereClause[] = ['project_bids.is_withdraw', '=', false];
        }

        return $query
            ->where($whereClause)
            ->whereNotNull('project_bids.id')
            ->get();
    }

//    public function authorizedToView(Request $request)
//    {
//        return true;
//    }
//
//    /**
//     * Authorize to Create
//     *
//     * @return bool true if role is matched
//     */
//    public static function authorizedToCreate(Request $request)
//    {
//
//        return true;
//    }
//
//    /**
//     * Authorize to Delete
//     *
//     * @return bool true if role is matched
//     */
//    public function authorizedToDelete(Request $request)
//    {
//        return true;
//    }
//
//    /**
//     * Authorize to Update
//     *
//     * @return bool true if role is matched
//     */
//    public function authorizedToUpdate(Request $request)
//    {
//        return true;
//    }
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/projects/' . $resource->project_id;
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/projects/' . $resource->project_id;
    }
}
