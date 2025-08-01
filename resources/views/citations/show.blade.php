<x-app-layout>

    <x-slot name="header">
        @include('components.header', ['name' => 'Citations'])
    </x-slot>

    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-gray-800">
                            Client: {{ $client->name ?? ($client->website ?? 'New Client') }}
                        </h2>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('citations.index') }}"
                                class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2.5 px-5 rounded-lg
                                transition duration-150 ease-in-out flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Selection
                            </a>
                        </div>
                    </div>

                    <form id="clientForm" action="{{ route('process.citation') }}" method="POST" class="space-y-8">
                        @csrf
                        <input type="hidden" name="client_id" value="{{ $client->id }}">

                        <div class="grid grid-cols-1 gap-8">
                            <!-- Cliente Info Section -->
                            <div class="bg-gray-50 p-8 rounded-xl shadow">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-3">Client Information
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="form-group">
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" id="email" name="email"
                                            value="{{ $client->email ?? '' }}" placeholder="Enter email address"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                        <input type="text" id="name" name="name"
                                            value="{{ $client->clientDetails->full_name ?? '' }}"
                                            placeholder="Enter name"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="country"
                                            class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                        <input type="text" id="country" name="country"
                                            value="{{ $client->city ?? '' }}" placeholder="Enter country"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="website_url"
                                            class="block text-sm font-medium text-gray-700 mb-2">Website URL</label>
                                        <input type="url" id="website_url" name="website_url"
                                            value="{{ $client->website ?? '' }}" placeholder="Enter website URL"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="business_name"
                                            class="block text-sm font-medium text-gray-700 mb-2">Business Name</label>
                                        <input type="text" id="business_name" name="business_name"
                                            value="{{ $client->name ?? '' }}" placeholder="Enter business name"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                </div>
                            </div>

                            <!-- Business Details Section -->
                            <div class="bg-gray-50 p-8 rounded-xl shadow">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-3">Business Details</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="form-group">
                                        <label for="phone_number"
                                            class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="tel" id="phone_number" name="phone_number"
                                            value="{{ $client->clientLocations->formatted_phone_number ?? '' }}"
                                            placeholder="Enter phone number"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="business_fax"
                                            class="block text-sm font-medium text-gray-700 mb-2">Business Fax</label>
                                        <input type="text" id="business_fax" name="business_fax"
                                            value="{{ $client->clientExtra->business_fax ?? '' }}"
                                            placeholder="Enter business fax"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="year_founded"
                                            class="block text-sm font-medium text-gray-700 mb-2">Year Founded</label>
                                        <input type="number" id="year_founded" name="year_founded"
                                            value="{{ $client->clientDetails->year_found ?? '' }}"
                                            placeholder="Enter year founded"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="num_employees"
                                            class="block text-sm font-medium text-gray-700 mb-2">Number of
                                            Employees</label>
                                        <input type="number" id="num_employees" name="num_employees"
                                            value="{{ $client->clientDetails->employees ?? '' }}"
                                            placeholder="Enter number of employees"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="owner_name"
                                            class="block text-sm font-medium text-gray-700 mb-2">Owner Name</label>
                                        <input type="text" id="owner_name" name="owner_name"
                                            value="{{ $client->clientExtra->owner_name ?? '' }}"
                                            placeholder="Enter owner name"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="num_citations"
                                            class="block text-sm font-medium text-gray-700 mb-2">Number of
                                            Citations</label>
                                        <input type="text" id="num_citations" name="num_citations"
                                            value="{{ $client->clientExtra->number_of_citations ?? '' }}"
                                            placeholder="Enter number of citations"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group md:col-span-2">
                                        <label for="business_hours"
                                            class="block text-sm font-medium text-gray-700 mb-2">Business Hours</label>
                                        <textarea id="business_hours" name="business_hours" rows="7"
                                            placeholder="Enter business hours (one day per line)"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                            @isset($client->clientLocations->weekday_text)
@php
    $hours = $client->clientLocations->weekday_text;
    if (is_string($hours) && json_decode($hours) !== null) {
        $hours = implode("\n", json_decode($hours, true));
    }
    echo trim($hours);
@endphp
@endisset
                                        </textarea>
                                        <p class="text-xs text-gray-500 mt-2">Enter each day on a new line. Example:
                                            "Monday: 10:00 AM – 4:00 PM"</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Information Section -->
                            <div class="bg-gray-50 p-8 rounded-xl shadow">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-3">Location Information
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="form-group">
                                        <label for="address_line1"
                                            class="block text-sm font-medium text-gray-700 mb-2">Address Line 1</label>
                                        <input type="text" id="address_line1" name="address_line1"
                                            value="{{ optional($client->clientLocations)->formatted_address }}"
                                            placeholder="Enter address line 1"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="address_line2"
                                            class="block text-sm font-medium text-gray-700 mb-2">Address Line 2</label>
                                        <input type="text" id="address_line2" name="address_line2"
                                            value="{{ $client->clientExtra->address_line2 ?? '' }}"
                                            placeholder="Enter address line 2"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="city"
                                            class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                        <input type="text" id="city" name="city"
                                            value="{{ $client->city ?? '' }}" placeholder="Enter city"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="state"
                                            class="block text-sm font-medium text-gray-700 mb-2">State</label>
                                        <input type="text" id="state" name="state"
                                            value="{{ $client->clientExtra->state ?? '' }}" placeholder="Enter state"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-2">ZIP
                                            Code</label>
                                        <input type="text" id="zip_code" name="zip_code"
                                            value="{{ $client->clientExtra->zip ?? '' }}"
                                            placeholder="Enter ZIP code"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Information Section -->
                            <div class="bg-gray-50 p-8 rounded-xl shadow">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-3">SEO Information</h3>
                                <div class="grid grid-cols-1 gap-8">
                                    <div class="form-group relative">
                                        <label for="keywords"
                                            class="block text-sm font-medium text-gray-700 mb-2">Keywords</label>
                                        <button type="button" id="generateKeywordsButton" data-target="keywords"
                                            class="absolute top-0 right-0 px-4 py-1.5 text-white bg-blue-600 hover:bg-blue-700 rounded-lg text-xs font-semibold transition duration-150 ease-in-out">
                                            Generate Content
                                        </button>
                                        <div id="loaderKeywords" class="absolute top-0 right-0 px-4 py-1.5 hidden">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                        <input type="text" id="keywords" name="keywords"
                                            value="{{ $client->clientSeo->keywords ?? '' }}"
                                            placeholder="Enter keywords"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group relative">
                                        <label for="short_description"
                                            class="block text-sm font-medium text-gray-700 mb-2">Short
                                            Description</label>
                                        <button type="button" id="generateShortContentButton"
                                            data-target="short_description"
                                            class="absolute top-0 right-0 px-4 py-1.5 text-white bg-blue-600 hover:bg-blue-700 rounded-lg text-xs font-semibold transition duration-150 ease-in-out">
                                            Generate Content
                                        </button>
                                        <div id="loaderShortContent"
                                            class="absolute top-0 right-0 px-4 py-1.5 hidden">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                        <textarea id="short_description" name="short_description" rows="2" placeholder="Enter short description"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">{{ $client->clientSeo->description_short ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group relative">
                                        <label for="long_description"
                                            class="block text-sm font-medium text-gray-700 mb-2">Long
                                            Description</label>
                                        <button type="button" id="generateLongContentButton"
                                            data-target="long_description"
                                            class="absolute top-0 right-0 px-4 py-1.5 text-white bg-blue-600 hover:bg-blue-700 rounded-lg text-xs font-semibold transition duration-150 ease-in-out">
                                            Generate Content
                                        </button>
                                        <div id="loaderLongContent" class="absolute top-0 right-0 px-4 py-1.5 hidden">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                        <textarea id="long_description" name="long_description" rows="4" placeholder="Enter long description"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">{{ $client->clientSeo->description_long ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group relative">
                                        <label for="spun_description"
                                            class="block text-sm font-medium text-gray-700 mb-2">Spun
                                            Description</label>
                                        <button type="button" id="generateSpunContentButton"
                                            data-target="spun_description"
                                            class="absolute top-0 right-0 px-4 py-1.5 text-white bg-blue-600 hover:bg-blue-700 rounded-lg text-xs font-semibold transition duration-150 ease-in-out">
                                            Generate Content
                                        </button>
                                        <div id="loaderSpunContent" class="absolute top-0 right-0 px-4 py-1.5 hidden">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                        <textarea id="spun_description" name="spun_description" rows="3" placeholder="Enter spun description"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">{{ $client->clientSeo->spun_description ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group relative">
                                        <label for="seo_email"
                                            class="block text-sm font-medium text-gray-700 mb-2">SEO Email</label>
                                        <input type="email" id="seo_email" name="seo_email"
                                            value="{{ $client->clientSeo->seo_email ?? ($client->email ?? '') }}"
                                            placeholder="Enter SEO email"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                </div>
                            </div>

                            <!-- Media Section -->
                            <div class="bg-gray-50 p-8 rounded-xl shadow">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-3">Media</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="form-group">
                                        <label for="logo_url"
                                            class="block text-sm font-medium text-gray-700 mb-2">Logo URL</label>
                                        <input type="url" id="logo_url" name="logo_url"
                                            value="{{ old('logo_url', url($client->clientDetails->logo_url ?? '')) }}"
                                            placeholder="Enter logo URL"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="video_url"
                                            class="block text-sm font-medium text-gray-700 mb-2">Video URL</label>
                                        <input type="url" id="video_url" name="video_url"
                                            value="{{ old('video_url', url($client->clientDetails->video_url ?? '')) }}"
                                            placeholder="Enter video URL"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="photo1_url"
                                            class="block text-sm font-medium text-gray-700 mb-2">Photo 1 URL</label>
                                        <input type="url" id="photo1_url" name="photo1_url"
                                            value="{{ old('photo1_url', url($client->clientDetails->photo1_url ?? '')) }}"
                                            placeholder="Enter photo 1 URL"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="photo2_url"
                                            class="block text-sm font-medium text-gray-700 mb-2">Photo 2 URL</label>
                                        <input type="url" id="photo2_url" name="photo2_url"
                                            value="{{ old('photo2_url', url($client->clientDetails->photo2_url ?? '')) }}"
                                            placeholder="Enter photo 2 URL"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                    <div class="form-group">
                                        <label for="photo3_url"
                                            class="block text-sm font-medium text-gray-700 mb-2">Photo 3 URL</label>
                                        <input type="url" id="photo3_url" name="photo3_url"
                                            value="{{ old('photo3_url', $client->clientExtra->photo_url3 ?? '') }}"
                                            placeholder="Enter photo 3 URL"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media Section -->
                            <div class="bg-gray-50 p-8 rounded-xl shadow">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-3">Social Media</h3>
                                <div class="form-group">
                                    <label for="social_media_links"
                                        class="block text-sm font-medium text-gray-700 mb-2">Social Media Links</label>
                                    <textarea id="social_media_links" name="social_media_links" rows="3"
                                        placeholder="Enter social media links (one per line)"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">{{ is_array(optional($client->clientSocial)->social_links) ? implode("\n", optional($client->clientSocial)->social_links) : optional($client->clientSocial)->social_links ?? '' }}</textarea>
                                    <p class="text-xs text-gray-500 mt-2">Enter each social media link on a new line
                                    </p>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="bg-gray-50 p-8 rounded-xl shadow">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-3">Additional
                                    Information</h3>
                                <div class="grid grid-cols-1 gap-8">
                                    <div class="form-group">
                                        <label for="directory_list"
                                            class="block text-sm font-medium text-gray-700 mb-2">Directory List</label>
                                        <textarea id="directory_list" name="directory_list" rows="3" placeholder="Enter directory list"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">{{ $client->clientExtra->directory_list ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="instructions_notes"
                                            class="block text-sm font-medium text-gray-700 mb-2">Instructions/Notes</label>
                                        <textarea id="instructions_notes" name="instructions_notes" rows="3" placeholder="Enter instructions or notes"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 py-3 px-4">{{ $client->clientExtra->instructions_notes ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-10">
                            <button type="submit" id="submitBtn"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-lg 
                                shadow-lg transition duration-150 ease-in-out flex items-center text-lg">
                                <i class="fas fa-save mr-3"></i>
                                Save Client Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Success/Error message -->
    <div id="responseMessage" class="fixed bottom-4 right-4 hidden">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <p id="responseText">Data saved successfully!</p>
            </div>
        </div>
    </div>


    <style>
        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    @push('js')
        <script>
            const client = @json($client);
            const routeGenerateContentLong = "{{ route('generate.content.long') }}";
            const routeGenerateContentShort = "{{ route('generate.content.short') }}";
            const routeGenerateContentSpun = "{{ route('generate.content.spun') }}";
            const routeGenerateContentKeywords = "{{ route('generate.content.keywords') }}";
        </script>
        @include('js.citation.save')
        @include('js.citation.generate_content')



        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let textarea = document.getElementById("social_media_links");

                try {
                    let jsonString = textarea.value.trim();

                    if (jsonString) {
                        let parsedData = JSON.parse(jsonString);

                        while (typeof parsedData === "string") {
                            parsedData = JSON.parse(parsedData);
                        }

                        if (Array.isArray(parsedData)) {
                            textarea.value = parsedData.join("\n");
                        }
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            });
        </script>
    @endpush
</x-app-layout>
