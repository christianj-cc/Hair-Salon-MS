@extends('layouts.admin')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.employees.index', $employee) }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Employee</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form id="editEmployeeForm" method="POST" action="{{ route('admin.employees.update', $employee) }}" enctype="multipart/form-data"
            x-data="{
                  first_name: '{{ old('first_name', $employee->first_name) }}',
                  last_name: '{{ old('last_name', $employee->last_name) }}',
                  email: '{{ old('email', $employee->user->email) }}',
                  personal_email: '{{ old('personal_email', $employee->personal_email) }}',
                  job_role_id: '{{ old('job_role_id', $employee->job_role_id) }}',
                  password: '',
                  password_confirmation: '',
                  showPassword: false,
                  showPasswordConfirmation: false,
                  get isComplete() {
                      return this.first_name.trim() !== '' &&
                             this.last_name.trim() !== '' &&
                             this.email.trim() !== '' &&
                             this.personal_email.trim() !== '' &&
                             this.job_role_id !== '' &&
                             (this.password.trim() === '' || (this.password.trim() !== '' && this.password_confirmation.trim() !== ''));
                  }
              }">
            @csrf
            @method('PUT')

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column: Image Upload & Preview -->
                <div class="lg:w-1/3">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <label for="image" class="cursor-pointer block">
                            <div id="previewContainer" class="mb-4 flex justify-center">
                                <img id="preview" src="#" alt="Preview" class="max-w-full max-h-64 object-contain hidden">
                                <div id="placeholder" class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                    @if($employee->image && image_exists($employee->image))
                                    <img src="{{ asset('storage/' . $customer->image) }}" alt="Current image" class="max-w-full max-h-48 object-contain">
                                    @else
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    @endif
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">Click to upload profile photo (optional)</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF (max 2MB)</p>
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" class="hidden">
                        @error('image') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Right Column: Form Fields -->
                <div class="lg:w-2/3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" id="first_name" x-model="first_name" value="{{ old('first_name', $employee->first_name) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" required>
                            @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" id="last_name" x-model="last_name" value="{{ old('last_name', $employee->last_name) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" required>
                            @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Work Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Work Email (for login) <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" x-model="email" value="{{ old('email', $employee->user->email) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" placeholder="example@gmail.com" required>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Personal Email (for invitations) -->
                        <div>
                            <label for="personal_email" class="block text-sm font-medium text-gray-700">Personal Email (for invitations) <span class="text-red-500">*</span></label>
                            <input type="email" name="personal_email" id="personal_email" x-model="personal_email" value="{{ old('personal_email', $employee->personal_email) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                            @error('personal_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Job Role -->
                        <div>
                            <label for="job_role_id" class="block text-sm font-medium text-gray-700">Job Role <span class="text-red-500">*</span></label>
                            <select name="job_role_id" id="job_role_id" x-model="job_role_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                <option value="">Select Role</option>
                                @foreach($jobRoles as $role)
                                <option value="{{ $role->id }}" {{ old('job_role_id', $employee->job_role_id) == $role->id ? 'selected' : '' }}>{{ $role->title }}</option>
                                @endforeach
                            </select>
                            @error('job_role_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Mobile Number -->
                        <div>
                            <label for="mobile_num" class="block text-sm font-medium text-gray-700">Mobile Number (11-digit) <span class="text-red-500">*</span></label>
                            <input type="tel" name="mobile_num" id="mobile_num" value="{{ old('mobile_num', $employee->mobile_num) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                maxlength="11" pattern="[0-9]*" inputmode="numeric"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            @error('mobile_num') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Birthdate -->
                        <div>
                            <label for="birthdate" class="block text-sm font-medium text-gray-700">Birthdate <span class="text-red-500">*</span></label>
                            <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate', $employee->birthdate?->format('Y-m-d')) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                            @error('birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                                <option value="">Select</option>
                                <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password (optional) -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password (optional)</label>
                            <div class="relative mt-1">
                                <input type="password" name="password" id="password" x-model="password"
                                    x-bind:type="showPassword ? 'text' : 'password'"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary pr-10">
                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg x-show="!showPassword" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <div class="relative mt-1">
                                <input type="password" name="password_confirmation" id="password_confirmation" x-model="password_confirmation"
                                    x-bind:type="showPasswordConfirmation ? 'text' : 'password'"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary pr-10">
                                <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg x-show="!showPasswordConfirmation" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPasswordConfirmation" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Hire Date -->
                        <div>
                            <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date <span class="text-red-500">*</span></label>
                            <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date', $employee->hire_date?->format('Y-m-d')) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                            @error('hire_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('admin.employees.index') }}" class="bg-none text-gray-900 px-6 py-2 rounded-md hover:bg-primary-dark transition">Cancel</a>
                        <button type="button" @click="confirmAction('Update Employee', 'Are you sure you want to update this employee?', '#editEmployeeForm', 
                        'POST', 'Update', true)" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition">Update Employee</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    });

    document.getElementById('previewContainer').addEventListener('click', function() {
        document.getElementById('image').click();
    });
</script>
@endsection