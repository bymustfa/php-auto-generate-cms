<?php
$schemaData = \Core\Generator::getSchemaList()['data'];
?>
@extends('shared.layout')
@section('title', 'Content')

@section('content')

    <div class="flex items-center" style="justify-content: space-between">
        <h1 class="text-gray-1100 font-bold text-[28px] leading-[35px] mb-[13px] dark:text-gray-dark-1100">
            <span>List</span>
            <small class="font-normal text-sm ml-3">({{$schemaData['count']}} pieces of data)</small>
        </h1>
        @include('components.form.button',
           ['text' => 'New Add', 'type' => 'link', 'href' => base_url('content/create'), 'iconName' => 'icon-add']
       )
    </div>

    <div class="border p-6 bg-neutral-bg rounded-2xl border-neutral pb-0 overflow-x-scroll scrollbar-hide dark:bg-dark-neutral-bg dark:border-dark-neutral-border mb-[52px] xl:overflow-x-hidden">

        <?php
        $body = [];
        foreach ($schemaData['list'] as $schema) {
            $body[] = [
                'id' => $schema['guid'],
                'display_name' => $schema['display_name'],
                'table_name' => $schema['table_name'],
                'model_name' => $schema['model_name'],
                'columns' => count($schema['columns']),

            ];
        }
        $contentTable = new \Core\HtmlTable();
        echo $contentTable
            ->setHeader([
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'display_name', 'label' => 'Name'],
                ['key' => 'table_name', 'label' => 'Table Name'],
                ['key' => 'model_name', 'label' => 'Model Name'],
                ['key' => 'columns', 'label' => 'Columns']
            ])
            ->setActionColumn([
                ['iconName' => 'icon-file-text', 'url' => base_url('content/details/{id}')],
                ['iconName' => 'icon-edit-3', 'url' => base_url('content/edit/{id}')],
                ['iconName' => 'icon-trash', 'url' => base_url('content/delete/{id}')],
            ])
            ->setBody($body)
            ->render();
        ?>
    </div>

@endsection
