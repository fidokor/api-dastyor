<div class="bs-stepper-header">
    <a class="step {{ request()->routeIs('migration.*') ? 'active' : '' }}" href="{{ route('migration.builder') }}">
        <button type="button" class="step-trigger">
              <span class="bs-stepper-circle">
                <i class="ti ti-file-description"></i>
              </span>
            <span class="bs-stepper-label">
                <span class="bs-stepper-title">Migratsiya yaratish</span>
            </span>
        </button>
    </a>
    <div class="line"></div>
    <a class="step {{ request()->routeIs('generator.*') ? 'active' : '' }}" href="{{ route('generator.index') }}">
        <button type="button" class="step-trigger">
              <span class="bs-stepper-circle">
                <i class="ti ti-code"></i>
              </span>
            <span class="bs-stepper-label">
                <span class="bs-stepper-title">Code generatsiya</span>
            </span>
        </button>
    </a>
    <div class="line"></div>
    <a class="step {{ request()->routeIs('advanced.*') ? 'active' : '' }}" href="{{ route('advanced.crud') }}">
        <button type="button" class="step-trigger">
            <span class="bs-stepper-circle"><i class="ti ti-file-3d"></i> </span>
            <span class="bs-stepper-label">
                <span class="bs-stepper-title">Kengaytirilgan kontroller</span>
            </span>
        </button>
    </a>
</div>