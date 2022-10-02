<?php

namespace Core;


class Controller extends Bootstrap
{
    /**
     * @param $view
     * @param $data
     * @return string
     */
    public function view($view, $data = [])
    {
        return $this->view->show($view, $data);
    }


}

?>
