<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Application Status</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body, html { height: 100%; margin: 0; background-color: #f8f9fa; font-family: system-ui, -apple-system, sans-serif; }
        .hero-section { background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative; padding-top: 6rem; padding-bottom: 5rem; }
        .overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.85); z-index: 1; }
        .content-wrapper { position: relative; z-index: 2; width: 100%; }
        .form-card { background-color: rgba(255, 255, 255, 0.98); border-radius: 16px; border-top: 8px solid #8b0000; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .section-header { background-color: #f8f9fa; border-left: 4px solid #8b0000; padding: 0.75rem 1rem; margin-bottom: 1.5rem; font-weight: 700; color: #333; }
        .btn-custom-red { background-color: #8b0000; color: white; transition: all 0.3s ease; }
        .btn-custom-red:hover { background-color: #660000; transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

    <nav class="fixed top-0 w-full z-50 bg-white/95 shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="#" class="font-bold text-xl text-gray-800 tracking-wider">
                <span style="color: #8b0000;">SCHOLARSHIP</span> SYSTEM
            </a>
            
            <div class="flex items-center space-x-6">
                <div class="relative group cursor-pointer">
                    <svg class="w-6 h-6 text-gray-600 hover:text-[#8b0000] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>

                    @if(isset($application))
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center w-3 h-3 bg-red-600 border-2 border-white rounded-full"></span>
                        
                        <div class="absolute right-0 mt-4 w-64 bg-white rounded-lg shadow-xl border border-gray-200 hidden group-hover:block z-50 overflow-hidden">
                            <div class="px-4 py-2 bg-gray-100 border-b">
                                <span class="text-sm font-bold text-gray-700">Application Status</span>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-2">UniFAST-TDP Scholarship</p>
                                @if($application->status == 'pending')
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded">⏳ PENDING APPROVAL</span>
                                @elseif($application->status == 'approved')
                                    <span class="inline-block bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">✅ APPROVED</span>
                                @else
                                    <span class="inline-block bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded">❌ DECLINED</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="absolute right-0 mt-4 w-64 bg-white rounded-lg shadow-xl border border-gray-200 hidden group-hover:block z-50">
                            <div class="p-4 text-center text-sm text-gray-500">No active applications.</div>
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="text-sm font-bold text-gray-600 hover:text-[#8b0000] transition uppercase tracking-wider">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="overlay"></div>
        <div class="max-w-5xl mx-auto px-4 content-wrapper">
            
            <div class="text-center mb-10 text-white">
                <h1 class="text-4xl font-bold mb-3 uppercase tracking-wide">Scholarship Portal</h1>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Track your application status or submit a new profile below.</p>
            </div>

            <div class="form-card p-8 md:p-12">
                
                {{-- IF THEY ACTUALLY HAVE AN APPLICATION IN THE DATABASE --}}
                @if(isset($application))
                    
                    <div class="text-center py-10">
                        @if($application->status == 'approved')
                            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-100 mb-6">
                                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h2 class="text-3xl font-extrabold text-green-800 mb-3">Congratulations!</h2>
                            <p class="text-xl text-gray-600 mb-8 font-medium">Your TDP Scholarship application has been <strong class="text-green-600">APPROVED</strong>.</p>
                        
                        @elseif($application->status == 'declined' || $application->status == 'rejected')
                            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-100 mb-6">
                                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            <h2 class="text-3xl font-extrabold text-red-800 mb-3">Application Declined</h2>
                            <p class="text-xl text-gray-600 mb-8 font-medium">Unfortunately, your TDP Scholarship application was declined by the administration.</p>
                        
                        @else
                            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-blue-100 mb-6">
                                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h2 class="text-3xl font-extrabold text-gray-800 mb-3">Application Received!</h2>
                            <p class="text-xl text-gray-600 mb-8 font-medium">Your application is currently <strong class="text-blue-600 uppercase">Pending</strong> and is awaiting review by the admin.</p>
                        @endif

                        <div class="border-t border-gray-200 pt-8 mt-4">
                            <a href="https://stcecilia.edu.ph/" target="_blank" class="inline-block bg-[#8b0000] text-white font-bold text-lg px-10 py-4 rounded-lg shadow-lg hover:bg-[#660000] hover:-translate-y-1 transition duration-300">
                                Visit https://stcecilia.edu.ph/ for more info
                            </a>
                        </div>
                    </div>

                {{-- IF NO APPLICATION EXISTS, SHOW THE BLANK FORM --}}
                @else

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-800 rounded shadow-sm">
                            <p class="font-bold">Success!</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                            <ul class="list-disc pl-5 font-semibold">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('submit.application') }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        {{-- PERSONAL INFORMATION --}}
                        <div>
                            <div class="section-header">PERSONAL INFORMATION</div>
                            <div class="grid md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">First Name *</label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Last Name *</label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Middle Name</label>
                                    <input type="text" name="middle_name" value="{{ old('middle_name') }}" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-4 gap-4 mt-4">
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Date of Birth *</label>
                                    <input type="date" name="birthdate" value="{{ old('birthdate') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Sex *</label>
                                    <select name="sex" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                        <option value="">Select</option>
                                        <option value="Male" @if(old('sex') == 'Male') selected @endif>Male</option>
                                        <option value="Female" @if(old('sex') == 'Female') selected @endif>Female</option>
                                    </select>
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Citizenship *</label>
                                    <input type="text" name="citizenship" value="{{ old('citizenship', 'Filipino') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Place of Birth *</label>
                                    <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                            </div>
                        </div>

                        {{-- CONTACT & ADDRESS --}}
                        <div>
                            <div class="section-header">CONTACT & ADDRESS</div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Street & Barangay *</label>
                                    <input type="text" name="address_street_barangay" value="{{ old('address_street_barangay') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Town/City/Municipality *</label>
                                    <input type="text" name="address_city" value="{{ old('address_city') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                            </div>
                            <div class="grid md:grid-cols-3 gap-4 mt-4">
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Province *</label>
                                    <input type="text" name="address_province" value="{{ old('address_province') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Zip Code</label>
                                    <input type="text" name="address_zip" value="{{ old('address_zip') }}" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Mobile Number *</label>
                                    <input type="tel" name="contact_number" value="{{ old('contact_number') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">E-mail Address *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                            </div>
                        </div>

                        {{-- EDUCATION --}}
                        <div>
                            <div class="section-header">EDUCATION (COURSE & GRADES)</div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Name of School Attended *</label>
                                    <input type="text" name="school" value="{{ old('school') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Course / Degree Program *</label>
                                    <input type="text" name="course" value="{{ old('course') }}" required placeholder="e.g. BS Information Technology" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                            </div>
                            <div class="grid md:grid-cols-4 gap-4 mt-4">
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">School ID *</label>
                                    <input type="text" name="school_id" value="{{ old('school_id') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Sector *</label>
                                    <select name="school_sector" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                        <option value="">Select</option>
                                        <option value="Public" @if(old('school_sector') == 'Public') selected @endif>Public</option>
                                        <option value="Private" @if(old('school_sector') == 'Private') selected @endif>Private</option>
                                    </select>
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Year Level *</label>
                                    <input type="text" name="year_level" value="{{ old('year_level') }}" required placeholder="e.g. 1st Year" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div class="col-span-1 border-2 border-red-200 rounded p-2 bg-red-50">
                                    <label class="block text-xs font-bold text-red-800 uppercase mb-1">GPA / General Average *</label>
                                    <input type="number" step="0.01" name="gpa" value="{{ old('gpa') }}" required placeholder="e.g. 1.5 or 90" class="w-full p-2 bg-white border border-red-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">School Address *</label>
                                <input type="text" name="school_address" value="{{ old('school_address') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                            </div>
                        </div>

                        {{-- FAMILY BACKGROUND --}}
                        <div>
                            <div class="section-header">FAMILY BACKGROUND & INCOME</div>
                            
                            <div class="grid md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Father's Full Name</label>
                                    <input type="text" name="father_name" value="{{ old('father_name') }}" placeholder="Leave blank if N/A" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Father's Occupation</label>
                                    <input type="text" name="father_occupation" value="{{ old('father_occupation') }}" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Mother's Full Name (Maiden)</label>
                                    <input type="text" name="mother_name" value="{{ old('mother_name') }}" placeholder="Leave blank if N/A" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Mother's Occupation</label>
                                    <input type="text" name="mother_occupation" value="{{ old('mother_occupation') }}" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Total Parents Gross Income (Annual) *</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2.5 text-gray-500 font-bold">₱</span>
                                        <input type="number" name="total_parent_income" value="{{ old('total_parent_income') }}" step="0.01" required placeholder="0.00" class="w-full pl-8 p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">No. of Siblings *</label>
                                    <input type="number" name="no_siblings" min="0" value="{{ old('no_siblings', 0) }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 outline-none">
                                </div>
                            </div>
                        </div>

                        {{-- REQUIRED DOCUMENTS --}}
                        <div>
                            <div class="section-header">REQUIRED DOCUMENTS</div>
                            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded mb-4 text-sm text-yellow-800">
                                <strong>Note:</strong> Please upload clear, scanned copies or photos of your documents. Allowed formats: PDF, JPG, PNG.
                            </div>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded text-center bg-gray-50">
                                    <label class="block font-bold text-gray-700 mb-2">Certificate of Registration (COR) *</label>
                                    <input type="file" name="cor_document" accept=".pdf,.jpg,.jpeg,.png" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-800 hover:file:bg-red-100 cursor-pointer">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded text-center bg-gray-50">
                                    <label class="block font-bold text-gray-700 mb-2">Certificate of Indigency *</label>
                                    <input type="file" name="indigency_document" accept=".pdf,.jpg,.jpeg,.png" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-800 hover:file:bg-red-100 cursor-pointer">
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t flex justify-end">
                            <button type="submit" class="btn-custom-red px-10 py-3 rounded text-lg font-bold uppercase tracking-wide">
                                Submit Application
                            </button>
                        </div>
                    </form>
                @endif
                {{-- END OF IF STATEMENT --}}

            </div>
        </div>
    </div>

</body>
</html>