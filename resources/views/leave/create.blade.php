<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leave') }}   
        </h2>
    </x-slot>
    <div class="py-12">
        

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
            <div class="mb-4 rounded-md bg-red-100 p-4 text-green-800 border border-red-300">
                {{ session('error') }}
            </div>
            @endif
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-green-800 border border-green-300">
                    {{ session('success') }}
                </div>
            @endif
            <form method="post" action="{{ route('leave.store') }}" class="mt-6 space-y-6">
                @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="">
                    <x-input-label for="reason" :value="__('Reason')" />
                    <x-text-input id="reason" name="reason" type="text" class="mt-1 block w-full" :value="old('reason', $leave->reason ?? '')" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('reason')" />
                </div>
                <div class="">
                    <x-input-label for="discription" :value="__('Discription')" />
                    <x-text-input id="discription" name="discription" type="text" class="mt-1 block w-full" :value="old('discription', $leave->discription ?? '')" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('discription')" />
                </div>
                <div class="">
                    <x-input-label for="from" :value="__('From')" />
                    <x-text-input id="from" name="from" type="date" class="mt-1 block w-full"  :value="old('from', $leave->from ?? '')" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('from')" />
                </div>
                <div class="">
                    <x-input-label for="to" :value="__('To')" />
                    <x-text-input id="to" name="to" type="date" class="mt-1 block w-full"  :value="old('to', $leave->to ?? '')" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('to')" />
                </div>
                <div>
                     <x-primary-button>{{ __('Apply') }}</x-primary-button>
                </div>
            </div>

            </form>

        </div>
    </div>

</x-app-layout>
