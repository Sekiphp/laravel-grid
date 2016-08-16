<?php

namespace Boduch\Grid\Components;

class DeleteButton extends RowAction
{
    /**
     * @return string
     */
    public function render()
    {
        return (string) $this->tag(
            'a',
            (string) $this->tag('i', '', ['class' => 'fa fa-trash-o']),
            [
                'href' => $this->buildActionUrl($this->data),
                'class' => 'btn btn-danger btn-xs',
                'title' => 'Usuń ten rekord',
                'data-toggle' => 'modal'
            ]
        );
    }
}
