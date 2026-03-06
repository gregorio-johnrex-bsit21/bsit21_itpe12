@extends('layouts.supervisor')

@section('content')

<h2 class="text-2xl font-bold mb-6">
Supervisor Dashboard
</h2>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

<div class="bg-white p-6 rounded-xl shadow">
<p class="text-sm text-gray-500">Total Interns</p>
<h3 class="text-2xl font-bold">24</h3>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<p class="text-sm text-gray-500">Hours Rendered</p>
<h3 class="text-2xl font-bold">1240</h3>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<p class="text-sm text-gray-500">Pending Tasks</p>
<h3 class="text-2xl font-bold">15</h3>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<p class="text-sm text-gray-500">Overall Success</p>
<h3 class="text-2xl font-bold">94%</h3>
</div>

</div>

@endsection