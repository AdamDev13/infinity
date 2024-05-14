<?php
namespace App\Nova\Traits;

trait PagePerOptionTrait {

    /**
     * Pagination - Top Dropdown filter - per page
     */
    public static function perPageOptions()
    {
        return [50, 100, 150, 200, 250];
    }

}

?>