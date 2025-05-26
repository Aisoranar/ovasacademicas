@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="identificacion" class="col-md-4 col-form-label text-md-end">{{ __('Identificación') }}</label>
                            <div class="col-md-6">
                                <input id="identificacion" type="text" class="form-control @error('identificacion') is-invalid @enderror" name="identificacion" value="{{ old('identificacion') }}" required autocomplete="identificacion">
                                @error('identificacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="rol" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>
                            <div class="col-md-6">
                                <select id="rol" class="form-control @error('rol') is-invalid @enderror" name="rol" required>
                                    <option value="">{{ __('Select a role') }}</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol }}" {{ old('rol') == $rol ? 'selected' : '' }}>
                                            {{ ucfirst($rol) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rol')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 programa-field" style="display: none;">
                            <label for="programa_id" class="col-md-4 col-form-label text-md-end">{{ __('Academic Program') }}</label>
                            <div class="col-md-6">
                                <select id="programa_id" class="form-control @error('programa_id') is-invalid @enderror" name="programa_id">
                                    <option value="">{{ __('Select a program') }}</option>
                                    @foreach($programasAcademicos as $programa)
                                        <option value="{{ $programa->id }}" {{ old('programa_id') == $programa->id ? 'selected' : '' }}>
                                            {{ $programa->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('programa_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="departamento_academico" class="col-md-4 col-form-label text-md-end">{{ __('Academic Department') }}</label>
                            <div class="col-md-6">
                                <select id="departamento_academico" class="form-control @error('departamento_academico') is-invalid @enderror" name="departamento_academico" required>
                                    <option value="">{{ __('Select a department') }}</option>
                                    @foreach($departamentosAcademicos as $departamento)
                                        <option value="{{ $departamento }}" {{ old('departamento_academico') == $departamento ? 'selected' : '' }}>
                                            {{ $departamento }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('departamento_academico')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="semestre_actual" class="col-md-4 col-form-label text-md-end">{{ __('Current Semester') }}</label>
                            <div class="col-md-6">
                                <input id="semestre_actual" type="number" class="form-control @error('semestre_actual') is-invalid @enderror" name="semestre_actual" value="{{ old('semestre_actual') }}" min="1" max="10">
                                @error('semestre_actual')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rolSelect = document.getElementById('rol');
    const programaField = document.querySelector('.programa-field');
    const programaSelect = document.getElementById('programa_id');

    function toggleProgramaField() {
        if (rolSelect.value === 'estudiante') {
            programaField.style.display = 'flex';
            programaSelect.required = true;
        } else {
            programaField.style.display = 'none';
            programaSelect.required = false;
            programaSelect.value = '';
        }
    }

    rolSelect.addEventListener('change', toggleProgramaField);
    toggleProgramaField(); // Run on page load
});
</script>
@endpush
@endsection
