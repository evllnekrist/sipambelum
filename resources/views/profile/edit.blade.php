<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <style>
        .alert-style {
            background-color: wheat;
            padding: 10px;
            border-radius: 10px;

        }
        .good-news {
            color: white;
            background-color: #03a9f4;
            animation-name: good-news;
            animation-duration: 5s;
        }
        .bad-news {
            background-color: #ffffb3;
            animation-name: bad-news;
            animation-duration: 5s;
        }
        @keyframes good-news {
            0% {background-color: #03a9f4;}
            25% {background-color: #b3e6fe;}
            50% {background-color: #03a9f4;}
            75% {background-color: #b3e6fe;}
            100% {background-color: #03a9f4;}
        }
        @keyframes bad-news {
            0% {background-color: yellow;}
            25% {background-color: #ffffb3;}
            50% {background-color: yellow;}
            75% {background-color: #ffffb3;}
            100% {background-color: yellow;}
        }
        /* Create two equal columns that floats next to each other */
        .column-avg {
        float: left;
        width: 50%;
        }
        .column-1 {
        float: left;
        width: 90%;
        }
        .column-2 {
        float: right;
        width: 10%;
        text-align: end;
        font-weight: bolder;
        }
        /* Clear floats after the columns */
        .row:after {
        content: "";
        display: table;
        clear: both;
}
    </style>
    @if (Session::has('status'))
    <div id="alert-1" class="alert-style {{Session::get('status_type')===true?'good-news':'bad-news'}} row">
        <div class="column-1">
            {{ Session::get('status') }}
        </div>
        <div class="column-2" onclick="document.getElementById('alert-1').style.display='none'">
            x
        </div>
    </div>      
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
