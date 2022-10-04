<?php
namespace Core;


class HtmlTable
{

    public $header = [];
    public $body = [];
    public $footer = [];
    public $actionColumn = [];

    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function setFooter($footer = null)
    {
        $this->footer = $footer;
        return $this;
    }

    public function setActionColumn($action = null)
    {
        $this->actionColumn = $action;
        return $this;
    }

    function renderHeader()
    {
        $html = '<thead><tr>';
        foreach ($this->header as $header) {
            $html .= '<th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
            <div class="flex items-center gap-x-[10px]">
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">
                            ' . $header['label'] . '
                        </span>
                        <!-- icon  -->
                    </div>
</th>';
        }
        $this->actionColumn && $html .= '<th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border  ml-auto">
            <div class="flex items-center gap-x-[10px]" style="justify-content: flex-end">
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500"> - </span> 
                    </div>
              </th>';
        $html .= '</tr></thead>';
        return $html;
    }

    function renderBody()
    {
        $html = '<tbody>';
        foreach ($this->body as $row) {
            $html .= '<tr>';

            foreach ($this->header as $header) {
                $cell = !empty($row[$header['key']]) ? $row[$header['key']] : '';
                $html .= '<td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                    <div class="flex items-center gap-x-[10px]">
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">
                            ' . $cell . '
                        </span>
                        <!-- icon  -->
                    </div>
                </td>';
            }

            if ($this->actionColumn) {
                $actionList = "";
                foreach ($this->actionColumn as $action) {
                    $url = str_replace('{id}', $row['id'], $action['url']);
                    $label = isset($action['label']) ? '<span class="text-white hover:text-[#C6CBD9]">' . $action['label'] . '</span>' : "";
                    $icon = isset($action['iconName']) ? $action['iconName'] : null;
                    $iconHtml = $icon ? '<img src="' . assets('images/icons/' . $icon . '.svg') . '" class="w-[16px] h-[16px] ml-3">' : '';
                    $actionList .= ' <a class="flex items-center bg-transparent p-0 gap-[7px]" href="' . $url . '">
                                        ' . $label . '
                                        ' . $iconHtml . '
                                  </a> ';
                }

                $html .= '<td class="border-b border-neutral dark:border-dark-neutral-border">
                    <div class="flex    items-center gap-x-[10px]" style="justify-content: flex-end"> 
                            ' . $actionList . '
                        
                    </div>
                </td>';
            }

            $html .= '</tr>';
        }
        $html .= '</tbody>';
        return $html;
    }

    function renderFooter()
    {
        $html = '<tfoot><tr>';
        foreach ($this->footer as $footer) {
            $html .= '<td>' . $footer . '</td>';
        }
        $html .= '</tr></tfoot>';
        return $html;
    }

    public function render()
    {
        $html = '<table class="w-full min-w-[900px]">';
        $this->header && $html .= $this->renderHeader();
        $this->body && $html .= $this->renderBody();
        $this->footer && $html .= $this->renderFooter();
        $html .= '</table>';
        return $html;
    }

}

?>
