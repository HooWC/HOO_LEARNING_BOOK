<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('authenticator saml') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    {{ __("You're logged in!") }}
                </div>

                <section title=".slideTOTP">
                    <div class="slideTOTP">
                        @if(Auth::user()->open_totp)
                            <input type="checkbox" value="None" id="slideTOTP" name="check" data-value="{{ Auth::user()->id }}" checked/>
                        @else
                            <input type="checkbox" value="None" id="slideTOTP" name="check" data-value="{{ Auth::user()->id }}"/>
                        @endif
                        <label for="slideTOTP"></label>
                    </div>
                </section>

            </div>
        </div>
    </div>
</x-app-layout>
