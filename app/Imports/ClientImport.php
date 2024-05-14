<?php

namespace App\Imports;

use App\Models\Client;
use Illuminate\Contracts\Validation\Factory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Sparclex\NovaImportCard\ImportNovaRequest;

class ClientImport implements ToModel, WithUpserts, WithHeadingRow
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $row["type"] = "client";
        return new Client($row);
    }

    public function uniqueBy()
    {
        return 'crm_id';
    }

    public function handle($resource)
    {
        $data = $this->data;

        $existed = Client::query()->whereIn('crm_id', array_column($data, 'crm_id'))->get();

        foreach ($data as $entry) {
            if (!array_key_exists("type",$entry)){
                $entry['type'] =  "client";
            }

            $existedModel = $existed->firstWhere('crm_id',$entry['crm_id']);
            if ($existedModel) {
                [$model, $callbacks] = $resource::fill(
                    new ImportNovaRequest($entry), $existedModel
                );
            }else{
                [$model, $callbacks] = $resource::fill(
                    new ImportNovaRequest($entry), $resource::newModel()
                );
            }
            $model->save();
            collect($callbacks)->each->__invoke();
        }
    }

    public function getValidationFactory()
    {
        return app(Factory::class);
    }
}
