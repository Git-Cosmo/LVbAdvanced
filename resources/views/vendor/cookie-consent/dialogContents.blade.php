<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-4 z-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-4 rounded-lg bg-gray-800 border border-gray-700 shadow-lg">
            <div class="flex items-center justify-between flex-wrap">
                <div class="max-w-full flex-1 items-center md:w-0 md:inline">
                    <p class="md:ml-3 text-gray-300 cookie-consent__message text-sm">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 sm:w-auto sm:ml-4">
                    <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
