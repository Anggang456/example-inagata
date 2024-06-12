@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
    <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Danger</span>
        <div>
            <span class="font-medium">Ensure that these requirements are met:</span>
            <ul class="mt-1.5 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-white uppercase bg-[#FF2D20]/10 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Tittle
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Upload
                    </th>
                    <th scope="col" class="px-6 py-3">
                        description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        made by
                    </th>
                    <th scope="col" class="px-6 py-3 flex justify-end">
                        <button data-modal-target="crud-modal" class="underline whitespace-nowrap" data-modal-toggle="crud-modal" type="button">
                            + MAKE
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($news as $news)
                <tr class="bg-[#FF2D20]/10 border-b text-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-900 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium line-clamp-1 w-40">
                        {{ $news->title }}
                    </th>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $news->updated_at->diffForHumans() ?? $news->created_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4 mb-4 line-clamp-1">
                        {{ $news->description }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $news->user->name }}
                    </td>
                    <td class="px-6 py-4 text-right flex items-center gap-3">
                        <button data-modal-target="details-modal-{{ $news->id }}" data-modal-toggle="details-modal-{{ $news->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Details</button>@include('details')
                        <button data-modal-target="edit-modal-{{ $news->id }}" data-modal-toggle="edit-modal-{{ $news->id }}" class="bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            Edit
                        </button>@include('edit')
                        <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="bg-red-500 text-white px-4 py-2 rounded" type="button">
                            Delete
                        </button>@include('delete')
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('make-modal')
@endsection