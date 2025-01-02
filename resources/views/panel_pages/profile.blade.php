@extends('layouts.main')
@section('main')
<section class="m-5 flex flex-col md:flex-row justify-center items-start gap-8 h-full pb-5">
    <!-- Sekcja profilu -->
    <div class="flex flex-col items-center p-6 rounded-lg shadow-lg w-full md:w-1/4 h-full company-bg">
        <!-- Zdjęcie profilowe -->
        <div class="mb-4">
            <img src="profile-image.jpg" alt="Profile" class="w-32 h-32 rounded-full border-4 border-gray-300 object-cover">
        </div>
        <!-- Informacje o profilu -->
        <div class="text-center">
            <p class="text-xl font-semibold text-gray-800">Adam Jozkowiak</p>
            <p class="text-sm text-gray-500">Software Developer</p>
            <p class="text-sm text-gray-500 mt-2">adam.jozkowiak@mail.pl</p>
        </div>
    </div>

    <!-- Sekcja tabeli -->
    <div class="relative overflow-y-auto shadow-lg rounded-lg w-full md:w-2/4 lg:w-2/3 bg-white p-6 max-h-[calc(100vh-150px)]">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Product List</h2>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Product Name</th>
                    <th scope="col" class="px-6 py-3">Color</th>
                    <th scope="col" class="px-6 py-3">Category</th>
                    <th scope="col" class="px-6 py-3">Price</th>
                </tr>
            </thead>
            <tbody>
                <!-- Wiersze tabeli -->
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900">Apple MacBook Pro 17"</th>
                    <td class="px-6 py-4">Silver</td>
                    <td class="px-6 py-4">Laptop</td>
                    <td class="px-6 py-4">$2999</td>
                </tr>
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900">Microsoft Surface Pro</th>
                    <td class="px-6 py-4">White</td>
                    <td class="px-6 py-4">Laptop PC</td>
                    <td class="px-6 py-4">$1999</td>
                </tr>
                <tr class="bg-white">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900">Magic Mouse 2</th>
                    <td class="px-6 py-4">Black</td>
                    <td class="px-6 py-4">Accessories</td>
                    <td class="px-6 py-4">$99</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
