<?php

namespace App\Presenters;


class UserPresenter extends Presenter
{
    /**
     * @return string
     */
    public function fullname()
    {
        return $this->name ?: $this->first_name . ' ' . $this->last_name;
    }




}
