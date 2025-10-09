<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leave') }}
        </h2>
        <x-a :href="route('leave.create')">Create</x-a>
    </div>


    </x-slot>
    <div class="py-12">
        

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-200">
  <thead class="bg-gray-50">
    <tr>
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        ID
      </th>
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Reason
      </th>
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Description
      </th>
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        From
      </th>
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        To
      </th>
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Action
      </th>
    </tr>
  </thead>
  <tbody class="bg-white divide-y divide-gray-200">
    @foreach ($leaves as $leave)
    <tr>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $leave->id }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $leave->reason }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $leave->discription }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $leave->from }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $leave->to }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
        <a href="{{ route('leave.edit', $leave) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
        <form action="{{ route('leave.destroy', $leave) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this leave?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>


        </div>
    </div>

</x-app-layout>
