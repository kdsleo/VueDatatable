<?php

namespace LaravelEnso\VueDatatable\app\Classes\Template\Validators;

use Illuminate\Support\Str;
use LaravelEnso\Helpers\app\Classes\Obj;
use LaravelEnso\VueDatatable\app\Exceptions\TemplateException;
use LaravelEnso\VueDatatable\app\Classes\Attributes\Column as Attributes;

class Meta
{
    public static function validate(Obj $column)
    {
        $attributes = collect($column->get('meta'));

        $diff = $attributes->diff(Attributes::Meta);

        if ($diff->isNotEmpty()) {
            throw new TemplateException(__(
                'Unknown Meta Parameter(s): ":attr"',
                ['attr' => $diff->implode('", "')]
            ));
        }

        if (Str::contains($column->name, '.')
            && ($attributes->contains('searchable') || $attributes->contains('sortable'))) {
            throw new TemplateException(__(
                'Nested columns do not support "searchable" nor "sortable": ":column"',
                ['column' => $column->get('name')]
            ));
        }
    }
}
