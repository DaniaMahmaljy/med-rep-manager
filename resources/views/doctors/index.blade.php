@extends('layouts.app')
@section('title','Doctors Management')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{__('local.Doctors Overview')}}</h3>
                <p class="text-subtitle text-muted">{{__('local.Manage and track all Doctors')}}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('local.Dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('local.Doctors')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                    <h5 class="card-title mb-0">{{__('local.Doctors List')}}</h5>
            </div>
            <div class="card-body">
            <div id="validationErrors" class=" text-danger mb-3"></div>
                    <table class="table table-sm" id="doctor_table">
                        <tbody></tbody>
                    </table>
         <div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editDoctorForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDoctorModalLabel">Edit Doctor: <span id="modalDoctorName"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <input type="hidden" id="doctorId" name="doctorId" />

          <div class="mb-3">
            <label for="doctorSupervisorSelect" class="form-label">Supervisors</label>
            <select id="doctorSupervisorSelect" name="supervisor_ids[]" multiple class="form-select">
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>



</div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('styles')
    @vite('resources/scss/pages/datatables.scss')
@endsection

@section('js')
<script>
    window.dataTableTranslations = @json([
        'headers' => __('datatables.headers'),
        'ui' => __('datatables.ui')
    ]);

    window.currentUser = {
        isSupervisor: {{ auth()->user()->hasRole('supervisor') ? 'true' : 'false' }}
    };

    window.supervisors = @json($supervisors);
    </script>
    @vite('resources/static/js/pages/doctorsTable.js')
@endsection
