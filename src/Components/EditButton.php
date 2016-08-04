<?php

namespace Boduch\Grid\Components;

class EditButton extends RowAction
{
    /**
     * @return string
     */
    public function render()
    {
        return (string) $this->tag(
            'a',
            (string) $this->tag('i', '', ['class' => 'fa fa-edit']),
            ['href' => $this->buildActionUrl($this->data), 'class' => 'btn btn-default btn-xs', 'title' => 'Edytuj ten rekord']
        );
    }
}
