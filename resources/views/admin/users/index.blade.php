@extends('admin.layout')

@section('title','Users')

@section('content')
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Header -->
    <div class="p-6 flex items-center justify-between border-b">
        <h1 class="text-2xl font-semibold text-gray-700">Manage Users</h1>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-4 text-gray-600 font-medium">ID</th>
                    <th class="py-3 px-4 text-gray-600 font-medium">Name</th>
                    <th class="py-3 px-4 text-gray-600 font-medium">Email</th>
                    <th class="py-3 px-4 text-gray-600 font-medium">Role</th>
                    <th class="py-3 px-4 text-gray-600 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">#{{ $u->id }}</td>
                        <td class="py-3 px-4 font-medium text-gray-800">{{ $u->name }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $u->email }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $u->role==='admin' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <form action="{{ route('admin.users.update',$u) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf @method('PUT')
                                <select name="role" class="border rounded px-2 py-1 text-sm">
                                    <option value="customer" @selected($u->role==='customer')>Customer</option>
                                    <option value="admin" @selected($u->role==='admin')>Admin</option>
                                </select>
                                <button class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded shadow">
                                    Save
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-4 border-t">
        {{ $users->links() }}
    </div>
</div>
@endsection
