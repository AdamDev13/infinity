<?php

namespace Ugduck\Infoclient;

use App\Models\ProjectView;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Card;

class Infoclient extends Card
{
    
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';
    


    public function __construct() {
 //       parent::__construct();

//        $this->withMeta(['setTitle' => 'Single Share' ]);
//        $this->withMeta(['model' => 'User']);
//        $this->withMeta(['selectColumns' => ['id','first_name', 'type'] ]);
    }

    public function currentClient()
    {
//        return ProjectView::where("user_id", Auth::user()->id)->first();
        return $this->withMeta(['currentClient' => Auth::user()->projectViews()->paginate(10)]);
    }


    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'infoclient';
    }
}
