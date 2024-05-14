<?php

namespace App\Nova\Actions;

use App\Mail\BidWithdraw;
use App\Models\Project;
use App\Models\ProjectBid;
use App\Models\ProjectFavorite;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Http\Requests\ActionRequest;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProjectBidExport extends DownloadExcel implements WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    public $onlyOnIndex = true;

//    private $project;
//    public function __construct(Request $request)
//    {
//        $this->entity = $request->get('viaResource');
//        if ($this->entity == "projects") {
//            $project_id = $request->get('viaResourceId');
//            $this->project = Project::find($project_id);
//
//        }
//    }
//
//    public function query()
//    {
//        return ProjectBid::where('project_id', $this->project_id);
//    }


    public function headings(): array
    {
        return [
            'Project Name',
            'Company',
            'File Link',
            'Base Price',
            'Contingency Fee',
            'Monthly Cost',
            'Monthly Tax Cost',
            'Non-Recurring Cost',
            'Term of Contract Month',
            'Total',
            'Status',
            'Is Withdraw',
            'Additional Attachment File Label',
            'Additional Attachment File URL',
            'Submitted At',
        ];
    }


    public function map($projectBid): array
    {
        return [
            $projectBid->project->name,
            $projectBid->userBelongs->name,
            $projectBid->file_url,
            $projectBid->base_price,
            $projectBid->contingency_fee,
            $projectBid->monthly_cost,
            $projectBid->monthly_tax_cost,
            $projectBid->non_recurring_cost,
            $projectBid->term_of_contract_month,
            $projectBid->total,
            $projectBid->status_name,
            $projectBid->is_withdraw ? "Yes" : "",
            $projectBid->attachments->pluck('label')->implode(', '),
            $projectBid->attachments->pluck('file_url')->implode(', '),
            $projectBid->created_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

//    public function handle(ActionRequest $request, Action $exportable): array
//    {
//
//        $response = Excel::download(
//            $exportable,
//            $this->getFilename(),
//            $this->getWriterType()
//        );
//
//        if ($this->project && !Carbon::now()->gt($this->project->deadline_date)){
//            return \is_callable($this->onFailure)
//                ? ($this->onFailure)($request, $response)
//                : Action::danger(__('ProjectBids could not be exported because deadline has not passed.'));
//        }
//
//        if (!$response instanceof BinaryFileResponse || $response->isInvalid()) {
//            return \is_callable($this->onFailure)
//                ? ($this->onFailure)($request, $response)
//                : Action::danger(__('Resource could not be exported.'));
//        }
//
//        return \is_callable($this->onSuccess)
//            ? ($this->onSuccess)($request, $response)
//            : Action::download(
//                $this->getDownloadUrl($response),
//                $this->getFilename()
//            );
//    }

}
